<?php

namespace App\Http\Controllers\Api\Vote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SaveVoteRequest;
use App\Models\Vote\VoteModel;

class VoteController extends Controller
{
    public function saveVote(SaveVoteRequest $request){
        $vote = VoteModel::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'answer_id' => $request->input('answer_id'),
            ],
            [
                'vote_type' => $request->input('vote_type'),
            ]
        );
    
        return response()->json([
            'message' => 'Vote registered successfully!',
            'response_code' => 200,
            'vote' => $vote,
        ], 200);
    }
}
