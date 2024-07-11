<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\URL;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Verified;



class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_token' => 'quora'.$request->email
        ]);
        $url = URL::temporarySignedRoute(
            'verify.email', now()->addMinutes(30), ['email' => $request->email,'hash'=> sha1('quora'.$request->email)]
        );
        Mail::to($request->email)->send(new VerifyEmail($url));

        $token = $user->createToken($user->email)->plainTextToken;

        return response()->json([
            'message' => 'User is successfully registered!',
            'response_code' => 200,
            'access_token' => $token,
            'user' => $user
        ]);
    }

    public function verifyEmail(Request $request){
        $user = User::where('email',$request->email)->first();
        if(!hash_equals(sha1($user->email_token), (string) $request->hash)){
            return;
        }
        if(!$user->email_verified_at){
            $user->markEmailAsVerified();
            event(new Verified($user));
        }
    }
}
