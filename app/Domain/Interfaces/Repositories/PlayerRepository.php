<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\Player;

interface PlayerRepository
{
    public function store(Player $player): void;
    public function find(string $id): Player;
    public function all():array;
    public function listPaginate(int $page = 1, int $perPage = 10, string $orderDirection = 'asc', string $orderField = 'name'): array;
    public function delete(string $id): void;
}
