<?php

namespace App\Services\Strategies;

use App\Domain\Entities\Guild;
use App\Services\Facades\GuildFacade;

class GuildBalanceVariance implements GuildBalanceStrategy
{

    public function balance(array $guilds): array
    {
        $guilds = GuildFacade::sortGuildsByAverageRating($guilds);

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
                    if (GuildFacade::canSwapPlayers($lowPlayer, $highPlayer)) {
                        if ($lowPlayer->getLevel() < $highPlayer->getLevel()) {
                            GuildFacade::swapPlayers($lowGuild, $highGuild, $lowPlayer, $highPlayer);
                            break 2;
                        }
                    }
                }
            }

            $guilds[$lowIndex] = GuildFacade::calculateAverageRating($lowGuild);
            $guilds[$highIndex] = GuildFacade::calculateAverageRating($highGuild);

            $guilds = GuildFacade::sortGuildsByAverageRating($guilds);
            $interactions++;
            $diferenceBetweenGuilds = $this->calculateGuildsVariance($guilds);
        }

        return $guilds;
    }

    /**
     * @param Guild[] $guilds
     * @return float
     */
    private function calculateGuildsVariance(array $guilds): float
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
}
