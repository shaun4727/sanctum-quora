<?php

namespace App\Models\Vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer\Answer;
use App\Models\User;

class VoteModel extends Model
{
    use HasFactory;
    protected $fillable = ['answer_id', 'user_id', 'vote_type'];

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
