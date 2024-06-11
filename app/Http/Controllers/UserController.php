<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\Media;
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

    public function uploadProfilePicture(ProfileRequest $request, $id)
    {
        $user = User::findOrFail($id);
        // Store the uploaded file
        if ($request->file('profile_image')->isValid()) {
            $media = Media::store($request);
            $mediaId = $media->id;

            $user->media_id = $mediaId;
            $user->save();
            return response()->json(['message' => 'Profile picture uploaded successfully']);
        }

        return response()->json(['error' => 'Failed to upload profile picture'], 500);
    }
}
