<?php

namespace App\Domain\Enums;

enum CharacterClass: string
{
    use EnumUtils;
    case WARRIOR = 'warrior';
    case MAGE = 'mage';
    case ARCHER = 'archer';
    case CLERIC = 'cleric';
}
