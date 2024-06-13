<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\ShowPostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/post",
     *     tags={"UserPost"},
     *     summary="Retrieve posts for the authenticated user",
     *     description="Retrieves all posts for the authenticated user.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Post")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            $user = $request->user();

            // Retrieve posts for the authenticated user
            $posts = Post::where('user_id', $user->id)->get();

            // Optionally, use a resource to format the posts
            $posts = PostResource::collection($posts);
            return response()->json([
                'success' => true,
                'data' => $posts,
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $user = $request->user();
            Post::store($request, null, $user->id);
            return response()->json(['success' => true, 'message' => "Post created succesfully"], 201);
        } else {
            return response()->json(['error' => 'User not stay in login'], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        if (Auth::check()) {
            $user = $request->user();

            // Retrieve posts for the authenticated user
            $posts = Post::where('user_id', $user->id)->get();

            $post = $posts->find($id);
            if ($post) {
                $post = new ShowPostResource($post);
                return response()->json(['success' => true, 'data' => $post,], 200);
            } else {
                return response()->json(['error' => 'Post not found'], 404);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::check()) {
            $user = $request->user();
            $post = Post::where('id', $id)->where('user_id', $user->id)->first();

            if ($post) {
                Post::store($request, $id, $user->id);
                return response()->json(['success' => true, 'message' => "Post updated successfully"], 200);
            } else {
                return response()->json(['error' => 'Post not found'], 404);
            }
        } else {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if (Auth::check()) {
            $user = $request->user();
            $post = Post::where('id', $id)->where('user_id', $user->id)->first();
            if ($post) {
                $post->delete();
                return response()->json(['success' => true, 'data' => true, 'message' => 'post deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Post not found'], 404);
            }
        } else {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }
}
