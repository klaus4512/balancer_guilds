<?php

namespace App\Infrastructure\Repositories\Session;

use App\Domain\Entities\Session;
use App\Domain\Interfaces\Repositories\SessionRepository;

class SessionEloquentRepository implements SessionRepository
{

    public function create(Session $session): void
    {
        $sessionModel = new \App\Models\Session();
        $sessionModel->fill($session->toArray());
        $sessionModel->save();
    }

    public function find(string $id): Session
    {
        $sessionModel = \App\Models\Session::query()->where('id', $id)->first();
        return new Session(
            $sessionModel->id,
            $sessionModel->name,
            $sessionModel->max_guild_players,
        );
    }
}
