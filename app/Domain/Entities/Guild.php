<?php

namespace App\Domain\Entities;

class Guild
{
    private string $id;
    private string $name;
    private float $averageRating = 0;
    private string $sessionId;
    private ?string $message = null;


    /**
     * @var Player[]
     */
    private array $players = [];

    public function __construct(string $id, string $name, string $sessionId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->sessionId = $sessionId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAverageRating(): float
    {
        return $this->averageRating;
    }

    public function setAverageRating(float $averageRating): void
    {
        $this->averageRating = $averageRating;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }



    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    public function setPlayers(array $players): void
    {
        $this->players = $players;
    }

    public function addPlayer(Player $player): void
    {
        $this->players[] = $player;
    }

    public function removePlayer(Player $player): void
    {
        foreach ($this->players as $key => $value) {
            if ($value->getId() === $player->getId()) {
                unset($this->players[$key]);
            }
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'average_rating' => $this->averageRating,
            'session_id' => $this->sessionId,
            'message' => $this->message,
        ];
    }
}
