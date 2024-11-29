<?php


namespace Database\Factories;

use App\Models\Answer\Answer;
use App\Models\User;
use App\Models\Question\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Answer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Associate with a new user
            'question_id' => Question::factory(), // Associate with a new question
            'answer' => $this->faker->paragraph(), // Generate a random paragraph for the answer
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

