<?php

namespace App\Infrastructure\Repositories\Player;

use App\Domain\Entities\Player;
use App\Domain\Enums\CharacterClass;
use App\Domain\Interfaces\Repositories\PlayerRepository;

class PlayerEloquentRepository implements PlayerRepository
{

    public function store(Player $player): void
    {
        $playerModel = new \App\Models\Player();
        $playerModel->fill($player->toArray());
        $playerModel->save();
    }

    public function find(string $id): Player
    {
        $playerModel = \App\Models\Player::query()->where('id', $id)->first();
        return new Player(
            $playerModel->id,
            $playerModel->name,
            $playerModel->character_class,
            $playerModel->level
        );
    }

    public function update(Player $player): void
    {
        $playerModel = \App\Models\Player::query()->where('id', $player->getId())->first();
        $playerModel->fill($player->toArray());
        $playerModel->save();
    }

    public function listPaginate(int $page = 1, int $perPage = 10, string $orderDirection = 'asc', string $orderField = 'name'): array
    {
        $players = \App\Models\Player::query()->orderBy($orderField, $orderDirection)->paginate($perPage, ['*'], 'page', $page);
        $players = $players->toArray();
        foreach ($players['data'] as $key => $player) {
            $players['data'][$key]['character_class'] = CharacterClass::getWithData($player['character_class']);
        }
        return $players;
    }

    public function delete(string $id): void
    {
        \App\Models\Player::query()->where('id', $id)->delete();
    }
}
