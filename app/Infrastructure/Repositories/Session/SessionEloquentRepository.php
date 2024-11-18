<?php

namespace App\Infrastructure\Repositories\Session;

use App\Domain\Entities\Guild;
use App\Domain\Entities\Player;
use App\Domain\Entities\Session;
use App\Domain\Enums\CharacterClass;
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

    public function findWithGuildsAndPlayers(string $id): Session
    {
        $sessionModel = \App\Models\Session::query()->where('id', $id)->with('guilds.players')->first();
        $session = new Session(
            $sessionModel->id,
            $sessionModel->name,
            $sessionModel->max_guild_players,
        );
        foreach ($sessionModel->guilds as $guildModel) {
            $guild = new Guild(
                $guildModel->id,
                $guildModel->name,
                $guildModel->session_id
            );
            $guild->setAverageRating($guildModel->average_rating);
            $guild->setMessage($guildModel->message);

            foreach ($guildModel->players as $playerModel) {
                $player = new Player(
                    $playerModel->id,
                    $playerModel->name,
                    $playerModel->character_class,
                    $playerModel->level
                );
                $guild->addPlayer($player);
            }
            $session->addGuild($guild);
        }

        return $session;
    }

    public function listPaginate(int $page = 1, int $perPage = 10, string $orderDirection = 'asc', string $orderField = 'name'): array
    {
        $sessionModel = \App\Models\Session::query()->orderBy($orderField, $orderDirection)->paginate($perPage, ['*'], 'page', $page);
        return $sessionModel->toArray();
    }
}
