<?php

namespace App\Interfaces\Repositories;

use App\Entities\Player;

interface PlayerRepository
{
    public function store(Player $player): void;
    public function find(string $id): Player;
    public function update(Player $player): void;

    public function listPaginate(int $page = 1, int $perPage = 10, string $orderDirection = 'asc', string $orderField = 'name'): array;

    public function delete(string $id): void;
}
