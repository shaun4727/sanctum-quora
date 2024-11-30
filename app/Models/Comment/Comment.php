<?php

namespace App\Models\Comment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer\Answer;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function answer(){
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function childComments()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }


    protected static function newFactory()
    {
        return \Database\Factories\CommentFactory::new();
    }
}
