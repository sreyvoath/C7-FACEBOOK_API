<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'profile_image',
    ];
    public static function store($request)
    {
        // Store the uploaded file and get its path
        $image = $request->file('profile_image')->store('images', 'public');

        // Create a new media record and save its path
        return self::create(['profile_image' => $image]);
    }
}
