<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\ShowPostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="PostSchema",
 *     title="Post",
 *     required={"id", "title", "content", "user_id", "created_at", "updated_at"},
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="title", type="string", example="Title"),
 *     @OA\Property(property="content", type="string", example="Content"),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="List posts",
     *     description="Get list of posts",
     *     tags={"Posts"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/PostSchema")
     *             )
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
     * @OA\Post(
     *     path="/api/post/create",
     *     summary="Create a new post",
     *     tags={"Posts"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Title"),
     *             @OA\Property(property="content", type="string", example="Post content")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Post created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/post/show/{id}",
     *     summary="Show a post",
     *     description="Show a specific post by ID",
     *     tags={"Posts"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/PostSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/post/update/{id}",
     *     summary="Update a post",
     *     description="Update a post",
     *     tags={"Posts"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Title"),
     *             @OA\Property(property="content", type="string", example="Updated content")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Post updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/post/delete/{id}",
     *     summary="Delete a post",
     *     description="Delete a specific post by its ID.",
     *     tags={"Posts"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Post deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
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
