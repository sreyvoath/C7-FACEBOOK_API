<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function store($request, $id=null, $user_id=null){
        $data = $request->only(['post_id', 'content']);
        $data['user_id'] = $user_id;
        return self::updateOrCreate(['id' => $id], $data);
    }

}
