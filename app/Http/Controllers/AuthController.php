<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $user = User::create($request->only("name", "email", "password"));
        $token = $user->createToken('API token')->plainTextToken;

        $data = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($data, 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required','string'],
        ]);

        if (!auth()->attempt($request->only('email', 'password')))
        {
            return response()->json([
               'message' => 'Invalid credentials'
            ], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('API token')->plainTextToken;

        $data = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($data, 200);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json([
           'message' => 'Logged out and your token has benn deleted'
        ]);
    }
}
