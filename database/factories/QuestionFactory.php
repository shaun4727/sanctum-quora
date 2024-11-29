<?php

namespace Database\Factories;

use App\Models\Question\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence(), // Generate a random sentence for the question
            'user_id' => User::factory(), // Associate with a new user
            'space_id' => json_encode([1]),
            'updated_at' => now(),
        ];
    }
}
