<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Str;
use App\Models\Space\SpaceModel;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Login Failed!',
                'response_code' => 401,
                'data' => []
            ],401);
        }
        $spaces = SpaceModel::whereJsonContains('user_id', $user->id)->get();
        $spaceIdList = array();

        foreach($spaces as $space){
            array_push($spaceIdList,$space->id);
        }
        $user->spaces = $spaceIdList;

        $token = $user->createToken($user->email)->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'response_code' => 200,
            'user' => $user
        ],200);

    }
}
