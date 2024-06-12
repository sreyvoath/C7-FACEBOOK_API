<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public static function list()
    {
        return self::all();
    }
    public static function store($request, $id = null, $user_id = null) {

        $data = $request->only('title');
        if ($request->hasFile('content')) {
            $request->validate([
                'content' => 'mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov,wmv|max:20480', 
            ]);
            $image = $request->file('content')->store('images', 'public');
            $data['content'] = Storage::url($image); 
    
        } else {
            $data['content'] = $request->input('content');
        }
        if ($user_id !== null) {
            $data['user_id'] = $user_id;
        }
        $post = self::updateOrCreate(['id' => $id], $data);
        return $post;
    }
    
}
