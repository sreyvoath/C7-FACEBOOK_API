<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public static function store($request, $id = null) {

        $data = $request->only('title', 'user_id');
        if ($request->hasFile('content')) {
            $request->validate([
                'content' => 'mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov,wmv|max:20480', 
            ]);
    
            $file = $request->file('content');
            $path = $file->store('public/images');
            $data['content'] = $path; 
    
        } else {
            $data['content'] = $request->input('content');
        }

        $post = self::updateOrCreate(['id' => $id], $data);
        return $post;
    }
    
}
