<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile\EmploymentCredentials;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function createEmploymentCredential(Request $request){

        $empCrd = EmploymentCredentials::create([
            'position' => $request->position,
            'company' => $request->company,
            'start' => Carbon::parse($request->start)->format('Y-m-d'),
            'end' => Carbon::parse($request->end)->format('Y-m-d'),
            'currentlyWorkHere' => $request->currentlyWorkHere
        ]);
        
        return response()->json([
            'message' => 'Employment Credentials are successfully saved.',
            'response_code' => 200,
            'EmplymentCredentials' => $empCrd
        ]);
    }
}
