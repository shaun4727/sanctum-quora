<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment\Comment;

class CommentController extends Controller
{
    public function createComment(Request $request){

        $comment = Comment::create([
            'answer_id' => $request->answer_id ,
            'user_id' => $request->user_id,
            'parent_id'=>  $request->parent_id,
            'content'=>  $request->content,
            'likes'=>  $request->likes,
            'dislikes'=>  $request->dislikes
        ]);

        return response()->json([
            'message' => 'Comment created successfully.',
            'response_code' => 200,
            'comment' => $comment
        ]);
    }
}
