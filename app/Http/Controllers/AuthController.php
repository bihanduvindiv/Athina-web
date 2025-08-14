<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * USER REGISTRATION - Easy to understand for VIVA
     * Step 1: Validate input data
     * Step 2: Check if email already exists
     * Step 3: Create new user with hashed password
     * Step 4: Login user automatically
     * Step 5: Return success with user data
     */
    public function register(Request $request)
    {
        // STEP 1: Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        // STEP 2: Check if user already exists (extra safety)
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return response()->json([
                'success' => false,
                'message' => 'Email already registered'
            ], 409);
        }

        // STEP 3: Create new user with hashed password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user' // Default role for new registrations
        ]);

        // STEP 4: Login user automatically after registration
        Auth::login($user);

        // STEP 5: Return success with user data
        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        ]);
    }

    /**
     * USER LOGIN - Updated to allow both admin and regular users
     * Step 1: Validate input
     * Step 2: Find user in database
     * Step 3: Verify password
     * Step 4: Login user and return success
     */
    public function login(Request $request)
    {
        // STEP 1: Validate input data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        // STEP 2: Find user in database by email
        $user = User::where('email', $request->email)->first();
        
        // If user doesn't exist, return error
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 401);
        }

        // STEP 3: Verify password using Hash
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Wrong password'
            ], 401);
        }

        // STEP 4: Login user and return success
        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        ]);
    }

    /**
     * SIMPLE LOGOUT - Easy to explain in VIVA
     * Step 1: Logout current user
     * Step 2: Clear session data
     * Step 3: Return success message
     */
    public function logout(Request $request)
    {
        // STEP 1: Logout current user
        Auth::logout();
        
        // STEP 2: Clear session data for security
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // STEP 3: Return success message
        return response()->json([
            'success' => true,
            'message' => 'Logout successful!'
        ]);
    }

    /**
     * GET CURRENT USER - Simple method for VIVA
     * Step 1: Get authenticated user
     * Step 2: Return user data or error
     */
    public function user(Request $request)
    {
        // STEP 1: Get currently authenticated user
        $user = Auth::user();
        
        // If no user is logged in, return error
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Not logged in'
            ], 401);
        }

        // STEP 2: Return user information
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        ]);
    }
}
