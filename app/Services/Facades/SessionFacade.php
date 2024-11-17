<?php

namespace App\Services\Facades;

use App\Domain\Entities\Session;
use App\Services\SessionService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void create(Session $session, array $players)
 */

class SessionFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SessionService::class;
    }
}
