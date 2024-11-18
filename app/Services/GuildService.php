<?php

namespace App\Services;

use App\Domain\Entities\Guild;
use App\Domain\Entities\Player;
use App\Domain\Enums\CharacterClass;
use App\Domain\Interfaces\UuidGenerator;
use App\Services\Facades\PlayerFacade;
use App\Services\Strategies\GuildBalanceStrategy;
use App\Services\Strategies\GuildBalanceVariance;

class GuildService
{
    private array $requiredGuildClasses = [
        CharacterClass::WARRIOR,
        CharacterClass::CLERIC,
    ];

    private array $optionalGuildClasses = [
        CharacterClass::MAGE,
        CharacterClass::ARCHER,
    ];

    public function __construct(
        private UuidGenerator $uuidGenerator,
        private GuildBalanceStrategy $guildBalanceStrategy
    )
    {
    }

    /**
     * @param Player[] $players
     * @param int $guildSize
     */
    public function generateGuilds(array $players, int $guildSize, string $sessionId): array
    {
        $players = PlayerFacade::sortByLevel($players);

        $groupedPlayers = PlayerFacade::groupByClassType($players, $this->requiredGuildClasses);
        $numberOfGuilds = $this->calculateNumberOfGuilds($players, $guildSize);
        $guilds = [];
        $guildIndex = 0;

        //Distribuir jogadores obrigatórios em cada guilda
        for ($i = 0; $i < $numberOfGuilds; $i++) {
            $guild = new Guild($this->uuidGenerator->generate(), 'Guilda '.$i + 1 , $sessionId);
            foreach ($groupedPlayers['required'] as $class => $player) {
                if (!empty($groupedPlayers['required'][$class])) {
                    $guild->addPlayer(array_shift($groupedPlayers['required'][$class]));
                }else{
                    $classDescription = CharacterClass::getWithData(CharacterClass::getFromName($class)->value)['description'];
                    $guild->setMessage($guild->getMessage() . 'Não foi possível adicionar a classe ' . $classDescription . " a guilda\n");
                    if (!empty($groupedPlayers['notRequired'])) {
                        $guild->addPlayer(array_shift($groupedPlayers['notRequired']));
                    }
                }
            }
            if (!empty($groupedPlayers['notRequired'])) {
                $guild->addPlayer(array_shift($groupedPlayers['notRequired']));
            }
            $guilds[$i] = $guild;
        }

        //Distribui os jogadores restares em cada time
        $restOfPlayers = [];
        foreach ($groupedPlayers['required'] as $class){
            foreach ($class as $player){
                $restOfPlayers[] = $player;
            }
        }

        foreach ($groupedPlayers['notRequired'] as $player){
            $restOfPlayers[] = $player;
        }

        foreach ($restOfPlayers as $player){
            $guilds[$guildIndex]->addPlayer($player);
            $guildIndex++;
            if ($guildIndex === $numberOfGuilds){
                $guildIndex = 0;
            }
        }
        return $guilds;

    }

    private function calculateNumberOfGuilds(array $players, int $guildSize): int
    {
        return round(count($players) / $guildSize, 0, PHP_ROUND_HALF_DOWN);
    }

    public function calculateAverageRating(Guild $guild): Guild
    {
        $playersAmount = 0;
        $totalRating = 0;
        foreach ($guild->getPlayers() as $player){
            $totalRating += $player->getLevel();
            $playersAmount++;
        }
        $guild->setAverageRating($totalRating / $playersAmount);
        return $guild;
    }

    public function balanceGuilds(array $guilds): array
    {
        return $this->guildBalanceStrategy->balance($guilds);
    }

    /**
     * @param Guild[] $guilds
     * @return array
     */
    public function sortGuildsByAverageRating(array $guilds): array
    {
        usort($guilds, static function (Guild $a, Guild $b) {
            return $a->getAverageRating() <=> $b->getAverageRating();
        });
        return $guilds;
    }

    public function swapPlayers(Guild $guild1, Guild $guild2, Player $player1, Player $player2): void
    {
        $guild1->removePlayer($player1);
        $guild2->removePlayer($player2);

        $guild1->addPlayer($player2);
        $guild2->addPlayer($player1);
    }

    public function canSwapPlayers(Player $player1, Player $player2): bool
    {
        if (in_array($player1->getCharacterClass(), $this->requiredGuildClasses, true)){
            return $player1->getCharacterClass() === $player2->getCharacterClass();
        }

        if (in_array($player1->getCharacterClass(), $this->optionalGuildClasses, true)){
            return in_array($player2->getCharacterClass(), $this->optionalGuildClasses, true);
        }
    }
}
