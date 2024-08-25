<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile\EmploymentCredentials;
use App\Models\Profile\EducationalCredentials;
use App\Models\Profile\LocationDetail;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function createEmploymentCredential(Request $request){

        $empCrd = EmploymentCredentials::create([
            'user_id' => $request->user_id,
            'position' => $request->position,
            'company' => $request->company,
            'start' => Carbon::parse($request->start)->format('Y-m-d'),
            'end' => Carbon::parse($request->end)->format('Y-m-d'),
            'currentlyWorkHere' => $request->currentlyWorkHere
        ]);
        
        return response()->json([
            'message' => 'Employment Credentials are successfully saved.',
            'response_code' => 200,
            'EmploymentCredentials' => $empCrd
        ]);
    }

    public function createEducationalCredential(Request $request){

        $edCrd = EducationalCredentials::create([
            'user_id' => $request->user_id,
            'school' => $request->school,
            'sscGpa' => $request->sscGpa,
            'college' => $request->college,
            'hscGpa' => $request->hscGpa,
            'university' => $request->university,
            'degree' => $request->degree,
            'gradYear' => $request->gradYear
        ]);

        return response()->json([
            'message' => 'Educational Credentials are successfully saved.',
            'response_code' => 200,
            'EducationalCredentials' => $edCrd
        ]);
    }

    public function createLocationDetail(Request $request) {
        $locationDtl = LocationDetail::create([
            'location' => $request->location,
            'startYear' => Carbon::parse($request->startYear)->format('Y-m-d'),
            'endYear' => Carbon::parse($request->endYear)->format('Y-m-d'),
            'user_id' => $request->user_id,
            'currentlyLive' => $request->currentlyLive
        ]);

        return response()->json([
            'message' => 'Location details are successfully saved.',
            'response_code' => 200,
            'EducationalCredentials' => $locationDtl
        ]);
    }

    public function getCredentialDetail($user_id){
        $educationalDetail = EducationalCredentials::where('user_id',$user_id)->first();
        $employmentDetail = EmploymentCredentials::where('user_id',$user_id)->first();
        $locationDetail = LocationDetail::where('user_id',$user_id)->first();

        return response()->json([
            'response_code' => 200,
            'credentialDetail' => [
                'employmentDetail'=> $employmentDetail,
                'educationalDetail'=> $educationalDetail,
                'locationDetail' => $locationDetail
            ]
        ]);
    }
}
