<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(LikeRequest $request): JsonResponse
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
                    $existingLike->update(['react_type' => $request-> react_type]);
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
}
