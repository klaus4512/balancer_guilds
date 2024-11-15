<?php

namespace App\Models;

use App\Enums\CharacterClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    //
    use SoftDeletes;

    protected $table = 'players';

    protected $keyType = 'string';

    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'character_class',
        'level'
    ];

    protected $casts = [
        'character_class' => CharacterClass::class
    ];
}
