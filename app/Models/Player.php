<?php

namespace App\Models;

use App\Domain\Enums\CharacterClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    //
    use SoftDeletes, HasFactory;

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

    public function guilds(): BelongsToMany
    {
        return $this->belongsToMany(Guild::class, 'guild_has_players', 'player_id', 'guild_id');
    }
}
