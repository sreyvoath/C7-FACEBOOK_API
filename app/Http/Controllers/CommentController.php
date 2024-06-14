<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * @OA\Schema(
 *     schema="Comment",
 *     title="Comment",
 *     required={"id", "post_id", "user_id", "content"},
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="post_id", type="integer", example="1"),
 *     @OA\Property(property="user_id", type="integer", example="1"),
 *     @OA\Property(property="content", type="string", example="This is a comment.")
 * )
 */

class CommentController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/comment",
     *     tags={"Comment"},
     *     summary="Create a new comment",
     *     description="Allows  users to create a comment.",
     *     security={{ "sanctum": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"post_id", "content"},
     *             @OA\Property(property="post_id", type="integer", example="1"),
     *             @OA\Property(property="content", type="string", example="Pretty.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User commented successfully")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=422, description="Invalid input")
     * )
     */
    
    public function create(CommentRequest $request): JsonResponse
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = $request->user();

            Comment::store($request, null, $user->id);
            return response()->json([
                'success' => true,
                'message' => "User commented successfully",
            ]);
        } else {
            // If not authenticated, return an error response
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/comment",
     *     tags={"Comment"},
     *     summary="List all comments",
     *     description="Returns a list of comments created by user.",
     *     security={{ "sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="List of comments retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Comment"))
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */

    public function list(Request $request)
    {
        $user = $request->user();
        $comments = Comment::where('user_id', $user->id)->get();
        return response()->json([
            'success' => true,
            'data' => $comments,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/comment/{id}",
     *     tags={"Comment"},
     *     summary="Delete a comment",
     *     description="Allows authenticated users to delete their own comments.",
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the comment to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Comment deleted successfully")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Comment not found")
     * )
     */

    public function destroy(Request $request, string $id)
    {
        if (Auth::check()) {
            $user = $request->user();
            $comment = Comment::where('id', $id)->where('user_id', $user->id)->first();
            if ($comment) {
                $comment->delete();
                return response()->json(['success' => true, 'data' => true, 'message' => 'Comment deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Comment not found'], 404);
            }
        } else {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }
}

