<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guild extends Model
{
    //
    protected $table = 'guilds';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'average_rating',
        'message',
        'session_id'
    ];

    public function session(): HasOne
    {
        return $this->hasOne(Session::class, 'id', 'session_id');
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'guild_has_players', 'guild_id', 'player_id');
    }
}
