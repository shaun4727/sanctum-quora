<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\Space\SpaceController;
use App\Http\Controllers\Api\Question\QuestionController;
use App\Http\Controllers\Api\Answer\AnswerController;
use App\Http\Controllers\Api\Vote\VoteController;
use App\Events\NotificationProcessed;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Models\User;
use App\Models\Space\SpaceModel;


// importing another api file
require __DIR__.'/auth.php';

Route::get('/user', function (Request $request) {
    $user = $request->user()->makeHidden('email_token');
    $spaces = SpaceModel::whereJsonContains('user_id', Auth::id())->get();
    $spaceIdList = array();

    foreach($spaces as $space){
        array_push($spaceIdList,$space->id);
    }
    $user->spaces = $spaceIdList;

    return $user;
})->middleware('auth:sanctum');

Route::prefix('profile')->group(function(){
    Route::post('/employment-credential', [ProfileController::class,'createEmploymentCredential'])->middleware('auth:sanctum');
    Route::post('/educational-credential', [ProfileController::class,'createEducationalCredential'])->middleware('auth:sanctum');
    Route::post('/location-detail', [ProfileController::class,'createLocationDetail'])->middleware('auth:sanctum');
    Route::post('/upload-profile-photo', [ProfileController::class,'uploadProfilePhoto'])->middleware('auth:sanctum');
    Route::get('/credential-detail/{user_id}', [ProfileController::class,'getCredentialDetail'])->middleware('auth:sanctum');
});


Route::prefix('space')->group(function(){
    Route::post('/create-space', [SpaceController::class,'createSpace'])->middleware('auth:sanctum');
    Route::get('/get-spaces',[SpaceController::class,'getAllSpaces'])->middleware('auth:sanctum');
    Route::get('/get-user-spaces',[SpaceController::class,'getAllSpacesForUser'])->middleware('auth:sanctum');
    Route::get('/follow-space/{space_id}',[SpaceController::class,'updateSpace'])->middleware('auth:sanctum');
    Route::get('/unfollow-space/{space_id}',[SpaceController::class,'removeUserFromSpace'])->middleware('auth:sanctum');
});


Route::prefix('question')->group(function(){
    Route::post('/create-question', [QuestionController::class,'createQuestion'])->middleware('auth:sanctum');
    Route::get('/get-questions',[QuestionController::class,'getAllQuestions'])->middleware('auth:sanctum');
    Route::get('/get-question-with-answers/{space_id}',[QuestionController::class,'getAllQuestionsWthAnswers'])->middleware('auth:sanctum');
    Route::get('/get-single-question-detail/{question_id}/{answer_id}',[QuestionController::class,'getSingleQuestionsWthAnswers'])->middleware('auth:sanctum');
    Route::get('/get-related-question',[QuestionController::class,'getRelatedQuestion'])->middleware('auth:sanctum');
});


Route::prefix('answer')->group(function(){
    Route::post('/create-answer', [AnswerController::class,'createAnswer'])->middleware('auth:sanctum');
    Route::get('/get-answers',[AnswerController::class,'getAllAnswers'])->middleware('auth:sanctum');
    Route::post('/answers/vote', [VoteController::class, 'saveVote'])->middleware('auth:sanctum');

});

Route::prefix('notification')->group(function(){
    Route::get('/get-all-notification', [NotificationController::class,'getAllNotification'])->middleware('auth:sanctum');
    Route::get('/get-all-answers/{question_id}/{notification_id}', [NotificationController::class,'getAllAnswers'])->middleware('auth:sanctum');
});

Route::get('/checking-channel', function(){
    broadcast(new NotificationProcessed("Hello"));
});