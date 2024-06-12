<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\ShowPostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::list();
        $posts = PostResource::collection($posts);
        return response()->json(['success' => true, 'data' =>$posts], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Post::store($request);
        return response()->json(['success' => true, 'message'=>"Post created succesfully"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        $post = new ShowPostResource($post);
        return response()->json(['success' => true, 'data' => $post], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Post::store($request, $id);
        return response()->json(['success' => true, 'message'=>"Post updated succesfully"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json([
            'success' => true,
            'data' => true,
            'message' => 'post deleted successfully'
        ], 200);
    }
}
