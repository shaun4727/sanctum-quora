<?php

namespace App\Http\Controllers\Api\Question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question\Question;

class QuestionController extends Controller
{
    public function createQuestion(Request $request){
     

        Question::create([
            'question' => $request->question ,
            'user_id' => $request->user_id,
            'space_id'=>  json_encode($request->space_id)
        ]);

        return response()->json([
            'message' => 'Question created successfully.',
            'response_code' => 200,
        ]);
    }

    public function getAllQuestions(){
        $questions = Question::latest()->get();

        $updatedSpaces = $questions->map(function ($question) {
            if ($question->space_id) {
                // Add the 'url' field to the model
                $question->space_id = json_decode($question->space_id,true);
            } else {
                // Handle cases where there is no image
                $question->space_id = null;
            }
            return $question;
        });
        return response()->json([
            'message' => 'Question created successfully.',
            'response_code' => 200,
            'questions' => $updatedSpaces
        ]);
    }

    public function getAllQuestionsWthAnswers(){
        return $questions = Question::with(['answers.user.profile'])->get();
    }
}
