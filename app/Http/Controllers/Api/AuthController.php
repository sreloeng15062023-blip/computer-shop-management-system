<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

/**
 * Controller: AuthController (API)
 *
 * Purpose:
 * Handles REST API authentication for the Computer Shop Management System:
 * - login(): Authenticates user credentials and issues a Sanctum Bearer Token.
 * - user(): Returns the currently authenticated user's profile and assigned role.
 * - logout(): Revokes the active token to end the user's session securely.
 */
class AuthController extends Controller
{
    /**
     * User Login API
     *
     * Endpoint: POST /api/auth/login
     * Access:   Public
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // 1. Validate incoming request parameters
        // 'email' must be provided, must be a valid email format
        // 'password' must be provided as a string
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. Find the user by their email address
        $user = User::where('email', $credentials['email'])->first();

        // 3. Verify user exists and check if the password matches the hashed password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            // Return 401 Unauthorized if credentials do not match
            return response()->json([
                'status'  => false,
                'message' => 'Invalid email or password. Please try again.',
            ], 401);
        }

        // 4. Generate a Sanctum personal access token for API requests
        // plainTextToken gives the unhashed bearer token to send to the client
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Load the associated Role information (e.g. role_name: Admin, Cashier)
        $user->load('role');

        // 6. Return standard success JSON response with user details and token
        return response()->json([
            'status'  => true,
            'message' => 'Login successful! Welcome back, ' . $user->name . '.',
            'data'    => [
                'user'  => $user,
                'token' => $token,
            ],
        ], 200);
    }

    /**
     * Get Authenticated User Profile
     *
     * Endpoint: GET /api/auth/user
     * Access:   Protected (requires Sanctum Bearer Token)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        // 1. Fetch user attached to the token via $request->user()
        $user = $request->user();

        // 2. Eager-load their role relationship
        $user->load('role');

        // 3. Return user profile JSON
        return response()->json([
            'status' => true,
            'data'   => $user,
        ], 200);
    }

    /**
     * User Logout API
     *
     * Endpoint: POST /api/auth/logout
     * Access:   Protected (requires Sanctum Bearer Token)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // 1. Delete the specific personal access token used for this current session
        // This instantly invalidates the Bearer token in MySQL
        $request->user()->currentAccessToken()->delete();

        // 2. Return logout confirmation message
        return response()->json([
            'status'  => true,
            'message' => 'Logged out successfully. Token has been revoked.',
        ], 200);
    }
}
