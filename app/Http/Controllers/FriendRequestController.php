<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendRequest as RequestsFriendRequest;
use App\Http\Requests\FriendSendRequest;
use App\Http\Resources\FriendResource;
use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    public function sendRequest(FriendSendRequest $request)
    {
        $receiverId = $request->input('receiver_id');

        if (Auth::check()) {
            $senderId = Auth::id();

            // Check if a friend request already exists
            $existingRequest = FriendRequest::where('sender_id', $senderId)
                ->where('receiver_id', $receiverId)
                ->first();

            if ($existingRequest) {
                return response()->json(['error' => 'Friend request already sent'], 400);
            }

            // Create a new friend request
            FriendRequest::create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'status' => 'pending',
            ]);

            return response()->json(['success' => true, 'message' => 'Friend request sent successfully']);
        }
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    public function acceptRequest(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $friendRequestId = $request->input('friend_request_id');

            $friendRequest = FriendRequest::where('sender_id', $friendRequestId)
                ->where('receiver_id', $userId)
                ->first();

            if ($friendRequest) {
                $friendRequest->update(['status' => 'accepted']);

                return response()->json(['success' => true, 'message' => 'Friend request accepted successfully']);
            }

            return response()->json(['error' => 'Friend request not found'], 404);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }

    public function rejectRequest(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $friendRequestId = $request->input('friend_request_id');
            $friendRequest = FriendRequest::where('sender_id', $friendRequestId)
                ->where('receiver_id', $userId)
                ->first();

            if ($friendRequest) {
                $friendRequest->delete();

                return response()->json(['success' => true, 'message' => 'Friend request rejected successfully']);
            }

            return response()->json(['error' => 'Friend request not found'], 404);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }
    public function getPendingRequests(): JsonResponse
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $pendingRequests = FriendRequest::where('receiver_id', $userId)
                ->where('status', 'pending')
                ->get();
            $friendReqesut = FriendResource::collection($pendingRequests);
            return response()->json(['success' => true, 'data' => $friendReqesut]);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }
    public function getFriends(): JsonResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            $friends = FriendRequest::get($user->id, null);
            return response()->json(['success' => true, 'data' => FriendResource::collection($friends)]);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }
    public function removeFriend(Request $request): JsonResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            $friendId = $request->input('friend_id');

            // Find the friend request where the authenticated user is the sender or receiver
            $friendRequest = FriendRequest::where(function ($query) use ($user, $friendId) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $friendId)
                    ->where('status', 'accepted');
            })->orWhere(function ($query) use ($user, $friendId) {
                $query->where('sender_id', $friendId)
                    ->where('receiver_id', $user->id)
                    ->where('status', 'accepted');
            })->first();

            if ($friendRequest) {
                // Delete the friend request
                $friendRequest->delete();

                return response()->json(['success' => true, 'message' => 'Friend removed successfully']);
            }

            return response()->json(['error' => 'Friend not found'], 404);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }
}
