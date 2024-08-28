<?php

namespace App\Models\Question;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer\Answer;

class Question extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function answers(){
        return $this->hasMany(Answer::class);
    }
}
