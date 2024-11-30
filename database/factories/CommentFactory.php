<?php

namespace Database\Factories;

use App\Models\Comment\Comment;
use App\Models\Answer\Answer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'answer_id' => Answer::factory(),
            'user_id' => User::factory(),
            'parent_id' => null,
            'content' => $this->faker->paragraph(),
            'likes' => $this->faker->numberBetween(0, 100),
            'dislikes' => $this->faker->numberBetween(0, 50),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function withParent(Comment $parentComment)
    {
        return $this->state(function (array $attributes) use ($parentComment) {
            return [
                'parent_id' => $parentComment->id,
                'answer_id' => null, // Set answer_id to null for child comments
            ];
        });
    }
}
