<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
    //
    protected $table = 'game_sessions';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'max_guild_players',
    ];

    public function guilds(): HasMany
    {
        return $this->hasMany(Guild::class, 'session_id', 'id');
    }
}
