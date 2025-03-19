<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('api_token');

            return response()->json(['token' => $token->plainTextToken], 200);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}