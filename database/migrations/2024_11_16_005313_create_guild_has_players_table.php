<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guild_has_players', function (Blueprint $table) {
            $table->timestamps();

            $table->foreignUuid('guild_id')->references('id')->on('guilds')->onDelete('cascade');
            $table->foreignUuid('player_id')->references('id')->on('players')->onDelete('cascade');

            $table->primary(['guild_id', 'player_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guild_has_players');
    }
};
