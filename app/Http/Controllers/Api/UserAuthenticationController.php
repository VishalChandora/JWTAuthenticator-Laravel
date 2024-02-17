<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthenticationController extends Controller
{
    /**
     * Register a new user.
     *
     * @param string $name The name of the user
     * @param string $email The email address of the user
     * @param string $password The password of the user
     * @return Illuminate\Http\JsonResponse The JSON response indicating success or failure
     */
    public function register(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|max:255', // Adjust min and max password length as needed
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create new user with validated data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password securely
        ]);

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'User created successfully!',
            'user' => $user, // Optionally, return the created user data
        ], 201); // 201 Created status code for successful resource creation
    }

    /**
     * Authenticate user and generate JWT token.
     *
     * @param string $email The email address of the user
     * @param string $password The password of the user
     * @return Illuminate\Http\JsonResponse The JSON response indicating success or failure
     */
    public function login(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Attempt to authenticate user and generate JWT token
        $token = JWTAuth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        // Check if authentication successful
        if (!empty($token)) {
            // Return success response with token
            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully!',
                'token' => $token,
            ], 200);
        }

        // Return error response for invalid login details
        return response()->json([
            'status' => false,
            'message' => 'Invalid login details',
        ], 401);
    }

    /**
     * Retrieve user profile data.
     *
     * @return Illuminate\Http\JsonResponse The JSON response containing user profile data
     */
    public function userProfile()
    {
        // Get authenticated user data
        $userData = auth()->user();

        // Return success response with user data
        return response()->json([
            'status' => true,
            'message' => 'User profile retrieved successfully!',
            'data' => $userData,
        ], 200);
    }

    /**
     * Refresh the JWT token.
     *
     * This method refreshes the JWT token for the authenticated user.
     * If the refresh is successful, it returns a success response with the new token.
     * If the refresh fails, it returns an error response indicating the failure.
     *
     * @return Illuminate\Http\JsonResponse The JSON response indicating success or failure
     */
    public function refreshToken()
    {
        // Refresh the JWT token
        $newToken = auth()->refresh();

        // Check if a new token is generated
        if (!empty($newToken)) {
            // Return success response with the new token
            return response()->json([
                'status' => true,
                'message' => 'Token refreshed successfully!',
                'token' => $newToken,
            ], 200);
        }

        // If no new token is generated, return an error response
        return response()->json([
            'status' => false,
            'message' => 'Failed to refresh token. Please log in again.',
        ], 401);
    }

    /**
     * Logout the authenticated user.
     *
     * This method logs out the currently authenticated user.
     * It returns a success response upon successful logout.
     *
     * @return Illuminate\Http\JsonResponse The JSON response indicating success
     */
    public function logout()
    {
        // Logout the authenticated user
        auth()->logout();

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully!',
        ], 200);
    }
}
