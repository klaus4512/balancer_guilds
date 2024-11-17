<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\Session;

interface SessionRepository
{
    public function create(Session $session): void;

    public function find(string $id): Session;
}
