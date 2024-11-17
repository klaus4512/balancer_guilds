<?php
namespace App\Services\Facades;

use App\Domain\Entities\Player;
use App\Services\PlayerService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array groupByClassType(array $players, array $requiredClass)
 * @method static array sortByLevel(array $players)
 */

class PlayerFacade extends Facade {
    protected static function getFacadeAccessor(): string
    {
        return PlayerService::class;
    }
}
