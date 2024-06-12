<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'user_id',
        'react_type',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public static function store($request, $id = null, $user_id)
    {
        $data = $request->only(['post_id', 'react_type']);
        $data['user_id'] = $user_id;

        return self::updateOrCreate(['id' => $id], $data);
    }
}
