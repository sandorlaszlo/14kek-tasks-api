<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
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
}
