<?php

namespace Database\Factories;

use App\Enums\ProfileStatus;
use App\Models\Administrator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    protected $model = \App\Models\Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $administratorIds = Administrator::all()->pluck('id')->toArray();
        return [
            'last_name' => $this->faker->name,
            'administrator_id' => $this->faker->randomElement($administratorIds),
            'first_name' => $this->faker->firstName,
            'image' => 'images/default.png',
            'status' => ProfileStatus::ACTIVE->value,
        ];
    }
}
