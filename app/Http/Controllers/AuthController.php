<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find user by email
        $user = User::where('user_email', $request->email)->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->user_password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Create token
        $token = $user->createToken('YourAppName')->plainTextToken;

        // Return token in the response
        return response()->json(['token' => $token, 'message' => 'Login successful']);
    }
}

