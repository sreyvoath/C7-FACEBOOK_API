<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendSendRequest;
use App\Http\Requests\FriendAcceptRejectRequest;
use App\Http\Resources\FriendResource;
use App\Models\FriendRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/** 
 * @OA\Schema(
 *     schema="FriendRequestSchema",
 *     title="FriendRequest",
 *     required={"id", "sender_id", "receiver_id", "status"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="sender_id", type="integer", example=1),
 *     @OA\Property(property="receiver_id", type="integer", example=2),
 *     @OA\Property(property="status", type="string", example="pending")
 * )
 */

class FriendRequestController extends Controller
{
    /** 
     * @OA\Post(
     *     path="/friend-request",
     *     summary="Send friend request",
     *     description="Send a friend request to another user",
     *     tags={"friend-requests"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="receiver_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Friend request sent successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Friend request already sent")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="User not authenticated")
     *         )
     *     )
     * )
     */
    public function sendRequest(FriendSendRequest $request)
    {
        if (Auth::check()) {
            $existingRequest = FriendRequest::existingRequest($request);
            if ($existingRequest) {
                return response()->json(['error' => 'Friend request already sent'], 400);
            }
            FriendRequest::store($request);
            return response()->json(['success' => true, 'message' => 'Friend request sent successfully']);
        }
        return response()->json(['error' => 'User not authenticated'], 401);
    }
/**
     * @OA\Post(
     *     path="/friend-request/accept",
     *     summary="Accept friend request",
     *     description="Accept a friend request",
     *     tags={"friend-requests"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="request_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Friend request accepted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="User not authenticated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Friend request not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Friend request not found")
     *         )
     *     )
     * )
     */
    public function acceptRequest(Request $request)
    {
        if (Auth::check()) {
            $friendRequest = FriendRequest::acceptRequest($request);
            if ($friendRequest) {
                $friendRequest->update(['status' => 'accepted']);
                return response()->json(['success' => true, 'message' => 'Friend request accepted successfully']);
            }
            return response()->json(['error' => 'Friend request not found'], 404);
        }
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    /** 
     * @OA\Post(
     *     path="/friend-request/reject",
     *     summary="Reject friend request",
     *     description="Reject a friend request",
     *     tags={"friend-requests"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="request_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Friend request rejected successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="User not authenticated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Friend request not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Friend request not found")
     *         )
     *     )
     * )
     */
    public function rejectRequest(Request $request)
    {
        if (Auth::check()) {

            $friendRequest = FriendRequest::rejectRequest($request);
            if ($friendRequest) {
                $friendRequest->delete();
                return response()->json(['success' => true, 'message' => 'Friend request rejected successfully']);
            }
            return response()->json(['error' => 'Friend request not found'], 404);
        }
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    /**
     * @OA\Get(
     *     path="/friend-requests/pending",
     *     summary="Get pending friend requests",
     *     description="Get a list of pending friend requests for the authenticated user",
     *     tags={"friend-requests"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/FriendRequestSchema"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="User not authenticated")
     *         )
     *     )
     * )
     */
    public function getPendingRequests(): JsonResponse
    {
        if (Auth::check()) {
            $pendingRequests = FriendRequest::getPending();
            $friendReqesut = FriendResource::collection($pendingRequests);
            return response()->json(['success' => true, 'data' => $friendReqesut]);
        }
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    /**
     * @OA\Get(
     *     path="/friends",
     *     summary="Get friends",
     *     description="Get a list of friends for the authenticated user",
     *     tags={"friend-requests"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/FriendRequestSchema"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="User not authenticated")
     *         )
     *     )
     * )
     */
    public function getFriends(): JsonResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            $friends = FriendRequest::get($user->id, null);
            return response()->json(['success' => true, 'data' => FriendResource::collection($friends)]);
        }
        return response()->json(['error' => 'User not authenticated'], 401);
    }
    /**
     * @OA\Delete(
     *     path="/friend/remove",
     *     summary="Remove friend",
     *     description="Remove a friend from the friend request list",
     *     tags={"friends"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="friend_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Friend removed successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Friend not found"
     *     )
     * )
     */
    public function removeFriend(Request $request): JsonResponse
    {
        if (Auth::check()) {
            $friendRequest = FriendRequest::remove($request);
            if ($friendRequest) {
                $friendRequest->delete();
                return response()->json(['success' => true, 'message' => 'Friend removed successfully']);
            }
            return response()->json(['error' => 'Friend not found'], 404);
        }
        return response()->json(['error' => 'User not authenticated'], 401);
    }
}
