<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPassword;
use App\Http\Resources\ProfileViewResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @OA\Info(title="My API", version="1.0")
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="Login user",
     *     description="Login a user and return a token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login success"),
     *             @OA\Property(property="access_token", type="string", example="token"),
     *             @OA\Property(property="token_type", type="string", example="Bearer")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        $user   = User::where('email', $request->email)->firstOrFail();
        $token  = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/me",
     *     tags={"Profile"},
     *     summary="Get current user profile",
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
    public function index(Request $request): JsonResponse
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = $request->user();
            $user = new ProfileViewResource($user);
            return response()->json([
                'message' => 'Login success',
                'data' => [$user],
            ]);
        } else {
            // If not authenticated, return an error response
            return response()->json(['error' => 'User not found'], 404);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     summary="Register a new user",
     *     description="Register a new user and return a token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="name-request"),
     *             @OA\Property(property="email", type="string", format="email", example="example@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful registration",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Register success"),
     *             @OA\Property(property="access_token", type="string", example="token"),
     *             @OA\Property(property="token_type", type="string", example="Bearer")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */

    public function register(RegisterRequest $request)
    {
        $token = User::store($request);
        return response()->json([
            'message'       => 'Register success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     summary="Logout user",
     *     description="Logout the authenticated user",
     *     security={{ "sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful logout",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logout successful")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout successful'
        ]);
    }

    // Controller method for initiating password reset

    /**
 * @OA\Post(
 *     path="/api/password/email",
 *     tags={"Authentication"},
 *     summary="Send Email Verification Code",
 *     description="Sends a verification code to the user's email if the email exists in the database.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email"},
 *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Passcode for verify",
 *         @OA\JsonContent(
 *             @OA\Property(property="Passcode for verify", type="string", example="ABC123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Email not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="Message", type="string", example="Email not found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The email field is required.")
 *         )
 *     )
 * )
 */
    public function sendEmailVerify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        // Check if the email exists in the users table
        $user = DB::table('users')->where('email', $request->email)->first();
        if ($user) {
            $passcode = Str::random(6);
            DB::table('reset_passwords')->insert([
                'email' => $request->email,
                'passcode' => $passcode,
            ]);
        }
        return $user
            ? response()->json(['Passcode for verify' => $passcode], 201)
            : response()->json(['Message' => "Email not found"], 404);
    }

/**
 * @OA\Post(
 *     path="/api/password/reset",
 *     tags={"Authentication"},
 *     summary="Reset password",
 *     description="Reset password",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"passcode", "password"},
 *             @OA\Property(property="passcode", type="string", example="123456"),
 *             @OA\Property(property="password", type="string", format="password", example="new_password")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Password reset successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Password reset successfully")
 *         )
 *     ),
 *     @OA\Response(response=400, description="Invalid input"),
 *     @OA\Response(response=401, description="Unauthorized"),
 *     @OA\Response(response=404, description="User not found")
 * )
 */
    public function resetPassword(ResetPassword $request)
    {

        // Find the record in password_resets table based on email and passcode
        $resetData = DB::table('reset_passwords')
            ->where('passcode', $request->passcode)
            ->first();

        if (!$resetData) {
            return response()->json(['error' => 'Invalid passcode'], 422);
        }
        $user = User::where('email', $resetData->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        DB::table('reset_passwords')->where('passcode', $request->passcode)->delete();
        return response()->json(['message' => 'Password reset successfully']);
    }
}
