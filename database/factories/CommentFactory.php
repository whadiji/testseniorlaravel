<?php

namespace Database\Factories;

use App\Models\Administrator;
use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $administratorIds = Administrator::all()->pluck('id')->toArray();
        $profileIds = Profile::all()->pluck('id')->toArray();
        return [
            'content' => $this->faker->paragraph,
            'administrator_id' => $this->faker->randomElement($administratorIds),
            'profile_id' => $this->faker->randomElement($profileIds),
        ];
    }
}
