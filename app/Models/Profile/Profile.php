<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory;
    protected $guarded = [];

    
    public function getImageAttribute($value){
        if(isset($value)){
            $path = 'public/images/uploaded/'.$value;
            return env('APP_URL').':8000'.Storage::url($path);
        }
        return null;
    }
}
