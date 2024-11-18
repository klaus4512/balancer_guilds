<?php

namespace Database\Factories;

use App\Domain\Enums\CharacterClass;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Player::class;

    public function definition(): array
    {
        return [
            //
            'id' => Str::uuid(),
            'name' => $this->faker->name,
            'character_class' => $this->faker->randomElement(array_column(CharacterClass::toArray(), 'value')),
            'level' => $this->faker->numberBetween(1, 100),
        ];
    }
}
