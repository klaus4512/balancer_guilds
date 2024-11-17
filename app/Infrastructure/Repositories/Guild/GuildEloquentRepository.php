<?php

namespace App\Infrastructure\Repositories\Guild;

use App\Domain\Entities\Guild;
use App\Domain\Entities\Player;
use App\Domain\Interfaces\Repositories\GuildRepository;

class GuildEloquentRepository implements GuildRepository
{

    public function store(Guild $guild): void
    {
        $guildModel = new \App\Models\Guild();
        $guildModel->fill($guild->toArray());
        $guildModel->save();

        $playersIds = [];
        foreach ($guild->getPlayers() as $player) {
            $playersIds[] = $player->getId();
        }

        $guildModel->players()->sync($playersIds);
    }

    public function find(string $id): Guild
    {
        $guildModel = \App\Models\Guild::query()->where($id, 'id')->first();
        $guild = new Guild($guildModel->id, $guildModel->name, $guildModel->session_id);
        $guild->setAverageRating($guildModel->average_rating);
        $guild->setMessage($guildModel->message);
        return $guild;
    }

    public function findWithPlayers(string $id): Guild
    {
        $guildModel = \App\Models\Guild::query()->where($id, 'id')->with('players')->first();
        $guild = new Guild($guildModel->id, $guildModel->name, $guildModel->session_id);
        $guild->setAverageRating($guildModel->average_rating);
        $guild->setMessage($guildModel->message);
        foreach ($guildModel->players as $playerModel) {
            $guild->addPlayer(new Player($playerModel->id, $playerModel->name, $playerModel->level, $playerModel->character_class));
        }
        return $guild;
    }
}
