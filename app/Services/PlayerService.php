<?php

namespace App\Services;

use App\Domain\Entities\Player;
use App\Domain\Interfaces\Repositories\PlayerRepository;

class PlayerService
{
    /**
     * @param Player[] $players
     */
    public function groupByClassType(array $players, array $requiredClass): array
    {
        $groupedPlayers = [];
        foreach ($players as $player) {
            if (in_array($player->getCharacterClass(), $requiredClass, true)) {
                $groupedPlayers['required'][$player->getCharacterClass()->name][] = $player;
            }else{
                $groupedPlayers['notRequired'][] = $player;
            }

        }
        return $groupedPlayers;
    }

    /**
     * @param Player[] $players
     */
    public function sortByLevel(array $players): array
    {
        usort($players, static function (Player $a, Player $b) {
            return $b->getLevel() - $a->getLevel();
        });
        return $players;
    }

}
