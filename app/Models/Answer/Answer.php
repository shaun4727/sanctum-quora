<?php

namespace App\Models\Answer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question\Question;
use App\Models\Comment\Comment;
use App\Models\Vote\VoteModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Answer extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Append the field to the model's array/JSON representation
    protected $appends = ['show_comment'];

    public function getShowCommentAttribute()
    {
        return false; // Default value
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }



    public function votes(){
        return $this->hasMany(VoteModel::class,'answer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userVote()
    {
        // A single user's vote on a specific answer
        return $this->hasOne(VoteModel::class)->where('user_id', Auth::id());
    }

    public function comments(){
        return $this->hasMany(Comment::class,'answer_id');
    }


    protected static function newFactory()
    {
        return \Database\Factories\AnswerFactory::new();
    }

}
