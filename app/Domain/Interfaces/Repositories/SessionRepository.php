<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\Session;

interface SessionRepository
{
    public function create(Session $session): void;

    public function find(string $id): Session;

    public function findWithGuildsAndPlayers(string $id): Session;

    public function listPaginate(int $page = 1, int $perPage = 10, string $orderDirection = 'asc', string $orderField = 'name'): array;
}
