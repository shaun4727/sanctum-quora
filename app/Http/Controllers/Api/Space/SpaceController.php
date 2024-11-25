<?php

namespace App\Http\Controllers\Api\Space;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Space\SpaceModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class SpaceController extends Controller
{
    public function createSpace(Request $request){

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

        

        SpaceModel::create([
            'user_id' => json_encode($request->user_id) ,
            'name' => $request->spaceName,
            'image' => $fileName,
            'description' => $request->description,
        ]);

        Storage::put('public/images/space/' . $fileName, $imageData);
        
        return response()->json([
            'message' => 'Space created successfully.',
            'fileName' => $fileName,
            'response_code' => 200,
        ]);
    }

    public function getAllSpacesForUser(){
        $spaces = SpaceModel::whereJsonContains('user_id', Auth::user()->id)
        ->latest()
        ->get()
        ->map(function ($space) {
            // Decode the user_id field into an array
            $space->user_id = json_decode($space->user_id, true);
            return $space;
        });

        $updatedSpaces = $spaces->map(function ($space) {
            if ($space->image) {
                // Add the 'url' field to the model
                $space->url = env('APP_URL') . ':8000' . Storage::url('public/images/space/' . $space->image);
            } else {
                // Handle cases where there is no image
                $space->url = null;
            }
            return $space;
        });

        return response()->json([
            'spaces' => $updatedSpaces,
            'response_code' => 200,
        ]);
    }

    public function getAllSpaces(){
        $spaces = SpaceModel::latest()->get()->map(function ($space) {
            // Decode the user_id field into an array
            $space->user_id = json_decode($space->user_id, true);
            return $space;
        });;

        $updatedSpaces = $spaces->map(function ($space) {
            if ($space->image) {
                // Add the 'url' field to the model
                $space->url = env('APP_URL') . ':8000' . Storage::url('public/images/space/' . $space->image);
            } else {
                // Handle cases where there is no image
                $space->url = null;
            }
            return $space;
        });

        return response()->json([
            'spaces' => $updatedSpaces,
            'response_code' => 200,
        ]);
    }

    public function updateSpace($space_id){
        $space = SpaceModel::findOrFail($space_id);
        
        $userIdArray = json_decode($space->user_id, true);
        array_push($userIdArray,Auth::user()->id);

        $space->setAttribute('user_id', json_encode($userIdArray));
        $space->save();

        return response()->json([
            'space' => $space,
            'message' => 'Space followed successfully!',
            'response_code' => 200,
        ]);
    }

    public function removeUserFromSpace($space_id){
        $space = SpaceModel::findOrFail($space_id);

        $userIdArray = json_decode($space->user_id, true);
        // Use array_filter to exclude the value
        $userIdArray = array_filter($userIdArray, function ($value) use ($space_id) {
            return $value != $space_id;
        });

        // Re-index the array (optional)
        $userIdArray = array_values($userIdArray);

        $space->setAttribute('user_id', json_encode($userIdArray));
        $space->save();

        return response()->json([
            'space' => $space,
            'message' => 'Space followed successfully!',
            'response_code' => 200,
        ]);
    }

}
