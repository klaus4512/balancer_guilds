<?php

namespace App\Services;

use App\Entities\Player;
use App\Interfaces\Repositories\PlayerRepository;

class PlayerService
{
    public function __construct(private readonly PlayerRepository $playerRepository)
    {
    }

    public function index(int $page):array
    {
        return $this->playerRepository->listPaginate($page);
    }

    public function store(Player $player): void
    {
        $this->playerRepository->store($player);
    }

    public function delete(string $id): void
    {
        $this->playerRepository->delete($id);
    }
}
