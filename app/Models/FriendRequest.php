<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FriendRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public static function store($request)
    {
        $receiverId = $request->input('receiver_id');
        $senderId = Auth::id();
        return self::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending',
        ]);
    }

    public static function existingRequest($request)
    {
        $receiverId = $request->input('receiver_id');
        $senderId = Auth::id();
        return self::where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->first();
    }

    public static function acceptRequest($request)
    {
        $userId = Auth::id();
        $friendRequestId = $request->input('friend_request_id');
        return self::where('sender_id', $friendRequestId)
            ->where('receiver_id', $userId)
            ->first();
    }

    public static function rejectRequest($request)
    {
        $userId = Auth::id();
        $friendRequestId = $request->input('friend_request_id');
        return self::where('sender_id', $friendRequestId)
            ->where('receiver_id', $userId)
            ->first();
    }

    public static function getPending()
    {
        $id = Auth::id();
        return self::where('receiver_id', $id)
            ->where('status', 'pending')
            ->get();
    }

    public static function get($userId)
    {
        return self::where('receiver_id', $userId)->where('status', 'accepted')->get();
    }

    public static function remove($request)
    {
        $user = Auth::user();
        $friendId = $request->input('friend_id');
        return self::where(function ($query) use ($user, $friendId) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $friendId)
                ->where('status', 'accepted');
        })->orWhere(function ($query) use ($user, $friendId) {
            $query->where('sender_id', $friendId)
                ->where('receiver_id', $user->id)
                ->where('status', 'accepted');
        })->first();
    }
}
