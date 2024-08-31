<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile\EmploymentCredentials;
use App\Models\Profile\EducationalCredentials;
use App\Models\Profile\LocationDetail;
use Carbon\Carbon;
use App\Models\Profile\Profile;
use Illuminate\Support\Facades\Storage;


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
        $profilePhoto = Profile::where('user_id',$user_id)->first();

        $photo = null;
        if(isset($profilePhoto->image)){
            $photo = $profilePhoto->image;
        }

        return response()->json([
            'response_code' => 200,
            'credentialDetail' => [
                'employmentDetail'=> $employmentDetail,
                'educationalDetail'=> $educationalDetail,
                'locationDetail' => $locationDetail,
                'profilePhoto' => $photo
            ]
        ]);
    }

    public function uploadProfilePhoto(Request $request){
        // checks if image already exists
        $image = Profile::where('user_id',$request->user_id)->first();

        $path = '/';
        if($image){
            $path = 'public/images/uploaded/'.$image->image;
        }
        if(Storage::exists($path) && $image){
            Storage::delete($path);
            $image->delete();
        }

        // stores image
        $imageData = $request->attachment['base64'];
        if(preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)){
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $type = strtolower($type[1]);
        }else{
            return response()->json(['error' => 'Invalid image data'], 422);
        }

        // Decode base64 string
        $imageData = base64_decode($imageData);

        $fileName = uniqid() . '.' . $type;


        Profile::create([
            'user_id' => $request->user_id,
            'image' => $fileName
        ]);
        Storage::put('public/images/uploaded/' . $fileName, $imageData);
        
        return response()->json([
            'message' => 'Profile photo created successfully.',
            'fileName' => $fileName,
            'response_code' => 200,
        ]);
    }
}
