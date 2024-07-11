<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LinkEmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ResetPasswordLink;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function sendResetLinkEmail(LinkEmailRequest $request){
        $url = URL::temporarySignedRoute(
            'password.reset', now()->addMinutes(30), ['email' => $request->email]
        );
        Mail::to($request->email)->send(new ResetPasswordLink($url));
        return response()->json([
            'message' => 'An email has been sent to your mail',
        ],200);
    }

    public function reset(ResetPasswordRequest $request){
        $user = User::where('email',$request->email)->first();

        if(!$user){
            return response()->json([
                'message' => 'Email address is not valid'
            ],404);
        }
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password reset successfully!',
            'response_code' => 200
        ],200);
    }
}
