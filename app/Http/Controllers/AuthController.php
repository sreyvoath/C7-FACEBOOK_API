<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
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

    public function index(Request $request)
    {
        $user = $request->user();
        $user->getAllPermissions();
        $user->getRoleNames();
        return response()->json([
            'message' => 'Login success',
            'data' => $user,
        ]);
    }
    public function register(RegisterRequest $request)
    {

        $token = User::store($request);
        // Return success response with the token
        return response()->json([
            'message'       => 'Register success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ], 201);
    }

    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }


    // Controller method for initiating password reset
    // public function sendEmailVerify(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);
    //     // Check if the email exists in the users table
    //     $user = DB::table('users')->where('email', $request->email)->first();
    //     if ($user) {
    //         $token = Str::random(20);
    //         $passcode = Str::random(6);
    //         DB::table('reset_passwords')->insert([
    //             'email' => $request->email,
    //             'token' => $token,
    //             'passcode' => $passcode,
    //         ]);
    //     }
    //     return $user
    //         ? response()->json(['Passcode for verify' => $passcode], 201)
    //         : response()->json(['Message' => "Email not found"], 404);
    // }

    // public function resetPassword(Request $request)
    // {
    //     $request->validate([
    //         'passcode' => 'required|string|min:6', // Add validation for passcode
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);

    //     // Find the record in password_resets table based on email and passcode
    //     $resetData = DB::table('reset_passwords')
    //         // ->where('email', $request->email)
    //         ->where('passcode', $request->passcode)
    //         ->first();

    //     if (!$resetData) {
    //         // If the passcode doesn't match or the record doesn't exist
    //         return response()->json(['error' => 'Invalid passcode'], 422);
    //     }

    //     // Proceed with resetting the password
    //     $status = Password::reset(
    //         ['email' => $resetData->email, 'token' => $resetData->token], // Pass email and token
    //         function ($user, $password) {
    //             $user->forceFill([
    //                 'password' => Hash::make($password),
    //             ])->save();
    //         }
    //     );

    //     // Delete the record from password_resets table after resetting the password
    //     DB::table('reset_passwords')
    //         ->where('email', $resetData->email)
    //         ->delete();

    //     return $status === Password::PASSWORD_RESET
    //         ? response()->json(['message' => "Reset password successfully"])
    //         : response()->json(['message' => 'Reset password fialed'], 422);
    // }
}
