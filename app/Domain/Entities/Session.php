<?php

namespace App\Domain\Entities;

class Session
{
    private string $id;
    private string $name;

    private int $maxGuildPlayers;

    /**
     * @var Guild[]
     */
    private array $guilds = [];
    public function __construct(string $id, string $name, int $maxGuildPlayers)
    {
        $this->id = $id;
        $this->name = $name;
        $this->maxGuildPlayers = $maxGuildPlayers;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxGuildPlayers(): int
    {
        return $this->maxGuildPlayers;
    }

    /**
     * @return Guild[]
     */
    public function getGuilds(): array
    {
        return $this->guilds;
    }

    public function setGuilds(array $guilds): void
    {
        $this->guilds = $guilds;
    }

    public function toArray():array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'max_guild_players' => $this->maxGuildPlayers,
        ];
    }

}
