<?php

namespace App\Http\Controllers\Api\Question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question\Question;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


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


    public function getAllQuestionsWthAnswers($space_id){
        $questions = Question::with([
            'answers.user.profile', // Eager load related users and their profiles for each answer
            'answers' => function ($query) {
                $query->withCount([
                    'votes as upvotes_count' => function (Builder $query) {
                        $query->where('vote_type', 'upvote'); // Count upvotes
                    },
                    'votes as downvotes_count' => function (Builder $query) {
                        $query->where('vote_type', 'downvote'); // Count downvotes
                    },
                ])
                ->with(['userVote' => function ($query) {
                    $query->select('id', 'answer_id', 'vote_type') // Fetch only relevant fields
                          ->where('user_id', Auth::id()); // Filter to the logged-in user's vote
                }]);
            }
        ])
        ->whereJsonContains('space_id', intval($space_id)) // Filter questions by space_id
        ->get();
        


        return response()->json([
            'response_code' => 200,
            'questions' => $questions
        ]);
    }
    public function getSingleQuestionsWthSingleAnswer($question_id,$answer_id){
        // function ($query) use ($answer_id, $question_id)
        $questions = Question::with(['answers' => function ($query) use ($answer_id) {
            $query->where('id', $answer_id)
            ->with(['userVote' => function ($query){
                $query->select('id', 'answer_id', 'vote_type') // Fetch only relevant fields
                          ->where('user_id', Auth::id()); // Filter to the logged-in user's vote
            }])
            ->withCount([
                'votes as upvotes_count' => function (Builder $query) {
                    $query->where('vote_type', 'upvote'); // Count upvotes
                },
                'votes as downvotes_count' => function (Builder $query) {
                    $query->where('vote_type', 'downvote'); // Count downvotes
                },
            ]);
        }, 'answers.user.profile'])
        ->where('id', $question_id)
        ->first();

        return response()->json([
            'response_code' => 200,
            'questions' => $questions
        ]);
    }

    public function getSingleQuestionWithAnswers($question_id){
        $questions = Question::with(['answers' => function ($query) {
            $query->with(['userVote' => function ($query){
                $query->select('id', 'answer_id', 'vote_type') // Fetch only relevant fields
                          ->where('user_id', Auth::id()); // Filter to the logged-in user's vote
            }])
            ->withCount([
                'votes as upvotes_count' => function (Builder $query) {
                    $query->where('vote_type', 'upvote'); // Count upvotes
                },
                'votes as downvotes_count' => function (Builder $query) {
                    $query->where('vote_type', 'downvote'); // Count downvotes
                },
            ]);
        }, 'answers.user.profile'])
        ->where('id', $question_id)
        ->first();

        return response()->json([
            'response_code' => 200,
            'questions' => $questions
        ]);
    }

    public function getRelatedQuestion(Request $request){
        
        $space_id = json_decode($request->query('space_id'),true);
        $question_id = $request->query('question_id');
        $questionList = Question::whereNotIn('id', [$question_id])->get();
        $questions_list = array();

        foreach($questionList as $question){
       
            $likedSpaceId = json_decode($question->space_id,true);

            $isForUser = !empty(array_intersect($space_id,$likedSpaceId));

            if($isForUser){
                array_push($questions_list,$question);
            }
        }
        
        return response()->json([
            'response_code' => 200,
            'question_list' => $questions_list
        ]);
    }
}
