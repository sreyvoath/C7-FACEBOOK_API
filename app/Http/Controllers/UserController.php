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

          /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"User"},
     *     summary="Get Users Profile",
     *     description="Returns the details of the currently authenticated user",
     *     security={{ "sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login success"),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    
    public function index()
    {
        $users = User::list();
        $users = UserResource::collection($users);
        return response()->json([
            'data' => $users,
        ]);

    }

     /**
     * @OA\Put(
     *     path="/api/me/{id}",
     *     tags={"Profile"},
     *     summary="Update user profile",
     *     description="Updates the profile of a user",
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile user updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Profile user updated successfully")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
    public function update(Request $request, string $id)
    {
        User::edit($request, $id);
        return ["success" => true, "Message" => "Profile user updated successfully"];
    }

    /**
     * @OA\Post(
     *     path="/api/upload/{id}",
     *     tags={"Profile"},
     *     summary="Upload user profile picture",
     *     description="Uploads a new profile picture for a user",
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="profile_image",
     *                     description="Profile image file",
     *                     type="file"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile picture uploaded successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Profile picture uploaded successfully")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=500, description="Failed to upload profile picture")
     * )
     */
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
