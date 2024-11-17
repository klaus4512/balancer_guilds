<?php

namespace App\Services;

use App\Domain\Entities\Guild;
use App\Domain\Entities\Player;
use App\Domain\Enums\CharacterClass;
use App\Domain\Interfaces\UuidGenerator;
use App\Services\Facades\PlayerFacade;

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

    public function __construct(private UuidGenerator $uuidGenerator)
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
            $guild = new Guild($this->uuidGenerator->generate(), 'Guilda '.$i, $sessionId);
            foreach ($groupedPlayers['required'] as $class => $player) {
                if (!empty($groupedPlayers['required'][$class])) {
                    $guild->addPlayer(array_shift($groupedPlayers['required'][$class]));
                }else{
                    $classDescription = CharacterClass::getWithData(CharacterClass::getFromName($class)->value)['description'];
                    $guild->setMessage($guild->getMessage() . 'Não foi possivel adicionar a classe ' . $classDescription . " a gilda\n");
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
        $guilds = $this->sortGuildsByAverageRating($guilds);

        $lowIndex = 0;
        $highIndex = count($guilds) - 1;
        $interactions = 0;
        $diferenceBetweenGuilds = $this->calculateGuildsVariance($guilds);

        while ($interactions < 10000 && $diferenceBetweenGuilds > 2) {
            $lowGuild = $guilds[$lowIndex];
            $highGuild = $guilds[$highIndex];

            $lowGuildPlayers = $lowGuild->getPlayers();
            $highGuildPlayers = $highGuild->getPlayers();

            foreach ($lowGuildPlayers as $lowPlayer) {
                foreach ($highGuildPlayers as $highPlayer) {
                    if ($this->canSwapPlayers($lowPlayer, $highPlayer)) {
                        if ($lowPlayer->getLevel() < $highPlayer->getLevel()) {
                            $this->swapPlayers($lowGuild, $highGuild, $lowPlayer, $highPlayer);
                            break 2;
                        }
                    }
                }
            }

            $guilds[$lowIndex] = $this->calculateAverageRating($lowGuild);
            $guilds[$highIndex] = $this->calculateAverageRating($highGuild);

            $guilds = $this->sortGuildsByAverageRating($guilds);
            $interactions++;
            $diferenceBetweenGuilds = $this->calculateGuildsVariance($guilds);
        }

        return $guilds;
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

    /**
     * @param Guild[] $guilds
     * @return float
     */
    public function calculateGuildsVariance(array $guilds): float
    {
        $numGuilds = count($guilds);
        if ($numGuilds === 0) {
            return 0.0;
        }

        $sum = 0;
        foreach ($guilds as $guild) {
            $sum += $guild->getAverageRating();
        }

        $mean = $sum / $numGuilds;

        $sumOfSquares = 0;
        foreach ($guilds as $guild) {
            $sumOfSquares += ($guild->getAverageRating() - $mean) ** 2;
        }

        return $sumOfSquares / $numGuilds;
    }

    private function swapPlayers(Guild $lowGuild, Guild $highGuild, Player $lowPlayer, Player $highPlayer): void
    {
        $lowGuild->removePlayer($lowPlayer);
        $highGuild->removePlayer($highPlayer);

        $lowGuild->addPlayer($highPlayer);
        $highGuild->addPlayer($lowPlayer);
    }

    private function canSwapPlayers(Player $player1, Player $player2): bool
    {
        if (in_array($player1->getCharacterClass(), $this->requiredGuildClasses, true)){
            return $player1->getCharacterClass() === $player2->getCharacterClass();
        }

        if (in_array($player1->getCharacterClass(), $this->optionalGuildClasses, true)){
            return in_array($player2->getCharacterClass(), $this->optionalGuildClasses, true);
        }
    }


}
