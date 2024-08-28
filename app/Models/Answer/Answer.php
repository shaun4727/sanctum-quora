<?php

namespace App\Models\Answer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question\Question;
use App\Models\User;

class Answer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
