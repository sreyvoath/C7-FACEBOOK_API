<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
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
    public function list(Request $request){
        $user = $request->user();
        $comments = Comment::where('user_id', $user->id)->get();
        return response()->json([
           'success' => true,
            'data' => $comments,
        ]);
    }
    public function destroy(Request $request, string $id){
        if (Auth::check()) {
            $user = $request->user();
            $comment = Comment::where('id', $id)->where('user_id', $user->id)->first();
            if ($comment) {
                $comment->delete();
                return response()->json(['success' => true, 'data' => true, 'message' => 'comment deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Comment not found'], 404);
            }
        } else {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }
}
