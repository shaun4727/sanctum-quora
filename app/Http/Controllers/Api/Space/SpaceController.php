<?php

namespace App\Http\Controllers\Api\Space;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Space\SpaceModel;
use Illuminate\Support\Facades\Storage;


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
            'user_id' => $request->user_id,
            'name' => $request->spaceName,
            'image' => $fileName
        ]);

        Storage::put('public/images/uploaded' . $fileName, $imageData);
        
        return response()->json([
            'message' => 'Space created successfully.',
            'fileName' => $fileName,
            'response_code' => 200,
        ]);
    }
}
