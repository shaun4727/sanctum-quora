<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifications\Notifications;
use App\Models\User;
use App\Models\Question\Question;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getAllNotification(){
        $notifications = Notifications::all();
        $spaces = User::find(Auth::user()->id)->spaces;
        $spaceIdList = array();
        foreach($spaces as $space){
            array_push($spaceIdList,$space->id);
        }
        
        $notificationForUser = array();
    
        foreach($notifications as $notification){
            $likedSpaceId = json_decode($notification->space_id,true);

            $isForUser = !empty(array_intersect($spaceIdList,$likedSpaceId));

            if($isForUser){
                array_push($notificationForUser,$notification);
            }
        }

        return response()->json([
            'response_code' => 200,
            'all_notifications' => $notificationForUser
        ],200);
       
    }

    public function getAllAnswers($question_id,$notification_id){
        
        $questions = Question::with(['answers.user.profile'])
        ->where('id',intval($question_id))->first();

        $notification = Notifications::find($notification_id);
        $notification->read = 1;
        $notification->save();

        return response()->json([
            'response_code' => 200,
            'questions' => $questions
        ]);
    }
}
