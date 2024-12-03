<?php

namespace App\Models\Comment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer\Answer;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function answer(){
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    protected $appends = ['is_depth_greater_than_one'];

    public function getDepthAttribute()
    {
        return $this->calculateDepth();
    }

    public function calculateDepth()
    {
        // Calculate depth from the root (depth 0 for root comment)
        return $this->parentComment ? 1 + $this->parentComment->calculateDepth() : 0;
    }

    public function getIsDepthGreaterThanOneAttribute()
    {
        // Return true if depth is greater than 1
        return $this->calculateDepth() > 1;
    }

    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function childComments()
    {
        // Recursive relationship to dynamically load all child comments and their userCommented
        return $this->hasMany(Comment::class, 'parent_id')->with(['childComments', 'userCommented']);
    }

    public function userCommented(){
        return $this->belongsTo(User::class,'user_id'); 
    }


    protected static function newFactory()
    {
        return \Database\Factories\CommentFactory::new();
    }
}
