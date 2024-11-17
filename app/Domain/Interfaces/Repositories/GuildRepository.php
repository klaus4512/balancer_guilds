<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\Guild;

interface GuildRepository
{
    public function store(Guild $guild): void;
    public function find(string $id): Guild;

    public function findWithPlayers(string $id): Guild;
}
