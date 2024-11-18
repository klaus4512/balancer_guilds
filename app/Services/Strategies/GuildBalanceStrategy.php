<?php

namespace App\Services\Strategies;

use App\Domain\Entities\Guild;

interface GuildBalanceStrategy
{
    /**
     * @param Guild[] $guilds
     * @return Guild[]
     */
    public function balance(array $guilds): array;
}
