<?php

namespace App\Models\Comment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function newFactory()
    {
        return \Database\Factories\CommentFactory::new();
    }
}
