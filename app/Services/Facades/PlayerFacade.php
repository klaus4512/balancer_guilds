<?php
namespace App\Services\Facades;

use App\Entities\Player;
use App\Services\PlayerService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array index(int $page)
 * @method static void store(Player $player)
 * @method static void delete(string $id)
 */

class PlayerFacade extends Facade {
    protected static function getFacadeAccessor(): string
    {
        return PlayerService::class;
    }
}
