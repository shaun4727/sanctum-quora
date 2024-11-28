<?php

namespace App\Http\Controllers\Api\Answer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Answer\Answer;
use App\Events\NotificationProcessed;
use App\Models\Notifications\Notifications;




class AnswerController extends Controller
{
    public function createAnswer(Request $request){
       

        $answer = Answer::create([
            'user_id' => $request->user_id,
            'question_id' => $request->question_id,
            'answer' => $request->answer
        ]);





        $notification = Notifications::create([
            'user_id' => $request->user_id,
            'question_id' => $request->question_id,
            'title' => $request->question,
            'answer_id' => $answer->id,
            'space_id' => json_encode($request->spaces),
            'read' => 0
        ]);

        $spaceIdList = array();
        $spaceIdList = json_decode($notification->space_id, true);
        $notification->setAttribute('space_id', $spaceIdList);

        broadcast(new NotificationProcessed($notification));

        

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

    public function checkingSocket(){
        broadcast(new NotificationProcessed());
    }
}
