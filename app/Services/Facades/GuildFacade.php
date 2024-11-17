<?php

namespace App\Services\Facades;

use App\Domain\Entities\Guild;
use App\Services\GuildService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array generateGuilds(array $players, int $guildSize, string $sessionId)
 * @method static array balanceGuilds(array $guilds)
 * @method static Guild calculateAverageRating(Guild $guild)
 * @method static float calculateGuildsVariance(array $guilds)
 * @method static array sortGuildsByAverageRating(array $guilds)
 */
class GuildFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GuildService::class;
    }
}
