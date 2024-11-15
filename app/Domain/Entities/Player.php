<?php

namespace App\Domain\Entities;

use App\Domain\Enums\CharacterClass;

class Player
{
    private string $id;
    private string $name;
    private CharacterClass $characterClass;
    private int $level;

    public function __construct(string $id, string $name, CharacterClass $characterClass, int $level)
    {
        if ($level < 1 || $level > 100) {
            throw new \InvalidArgumentException('O nível deve ser entre 1 e 100');
        }

        $this->id = $id;
        $this->name = $name;
        $this->characterClass = $characterClass;
        $this->level = $level;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCharacterClass(): CharacterClass
    {
        return $this->characterClass;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'character_class' => $this->characterClass,
            'level' => $this->level,
        ];
    }

}
