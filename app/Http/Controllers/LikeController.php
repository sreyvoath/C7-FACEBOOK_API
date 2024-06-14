<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="Like",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="post_id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="react_type", type="string", example="like"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 */
class LikeController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/likes",
     *     tags={"Likes"},
     *     summary="Create",
     *     description="Allows authenticated users to like or unlike a post, or update their reaction type.",
     *     security={{ "sanctum": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"post_id", "react_type"},
     *             @OA\Property(property="post_id", type="integer", example=1),
     *             @OA\Property(property="react_type", type="string", example="like")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operation successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User liked successfully")
     *         )
     *     ),
     *     @OA\Response(response=401, description="User not authenticated")
     * )
     */
    public function create(LikeRequest $request): JsonResponse
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = $request->user();

            $existingLike = Like::where('post_id', $request->post_id)
                ->where('user_id', $user->id)
                ->where('react_type', $request->react_type)
                ->first();

            if ($existingLike) {
                if ($existingLike->react_type !== $request->react_type) {
                    $existingLike->update(['react_type' => $request->react_type]);
                    return response()->json(['success' => true, 'message' => 'Post reaction updated successfully']);
                } else {
                    $existingLike->delete(); // Unlike the post
                    return response()->json(['success' => true, 'message' => 'Post unliked successfully']);
                }
            }

            Like::store($request, null, $user->id);
            return response()->json([
                'success' => true,
                'message' => "User liked successfully",
            ]);
        } else {
            // If not authenticated, return an error response
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/likes",
     *     tags={"Likes"},
     *     summary="List likes",
     *     description="Returns a list of likes for the authenticated user.",
     *     security={{ "sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Operation successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/Like")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="User not authenticated")
     * )
     */
    public function list(Request $request)
    {
        $user = $request->user();
        $likes = Like::where('user_id', $user->id)->get();
        return response()->json([
            'success' => true,
            'data' => $likes,
        ]);
    }
}
