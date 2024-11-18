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
        if($maxGuildPlayers < 2) {
            throw new \InvalidArgumentException('O número de jogadores por Guilda deve ser maior que 3');
        }

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

    public function addGuild(Guild $guild): void
    {
        $this->guilds[] = $guild;
    }

    public function toArray():array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'max_guild_players' => $this->maxGuildPlayers,
            'guilds' => array_map(static fn(Guild $guild) => $guild->toArray(), $this->guilds)
        ];
    }

}
