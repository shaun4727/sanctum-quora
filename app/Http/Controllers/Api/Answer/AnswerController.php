<?php

namespace App\Http\Controllers\Api\Answer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Answer\Answer;


class AnswerController extends Controller
{
    public function createAnswer(Request $request){

        Answer::create([
            'user_id' => $request->user_id,
            'question_id' => $request->question_id,
            'answer' => $request->answer
        ]);

        return response()->json([
            'message' => 'Answer created successfully.',
            'response_code' => 200,
        ]);

    }

    public function getAllAnswers(){
        $answers = Answer::latest()->get();

        return response()->json([
            'answers' => $answers,
            'response_code' => 200,
        ]);
    }
}
