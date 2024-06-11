<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function me(Request $request): JsonResponse
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // If authenticated, return the user data
            return response()->json([
                'message' => 'Login success',
                'data' => $request->user(),
            ]);
        } else {
            // If not authenticated, return an error response
            return response()->json(['error' => 'User not found'], 404);
        }
    }


    public function index()
    {
        $users = User::list();
        $users = UserResource::collection($users);
        return response()->json([
            'data' => $users,
        ]);
    }


    public function update(Request $request, string $id)
    {
        User::edit($request, $id);
        return ["success" => true, "Message" => "Profile user updated successfully"];
    }
}
