<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
     public function logout(Request $request){
        if(Auth::user()->currentAccessToken()->delete()){
            return response()->json([
                'message' => 'You are logged out!',
                'response_code' => 200
            ],200);
        }
     }
}
