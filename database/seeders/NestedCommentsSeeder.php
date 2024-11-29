<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment\Comment;

class NestedCommentsSeeder extends Seeder
{
    public function run(): void
    {
        Comment::factory()->count(30)->create()->each(function ($parentComment) {
            // Create a nested comment for each parent comment
            Comment::factory()->withParent($parentComment)->create();
        });
    }
}

