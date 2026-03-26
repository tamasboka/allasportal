<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);

        return response()->json([
            "success" => true,
            "message" => "Register successfully",
            'user' => $user
        ], 201);
    }

    public function login(UserRequest $request)
    {
        $validated = $request->validated();

        if (!Auth::attempt($validated)) {
            return response()->json([
                "success" => false,
                "message" => "Unauthorized"
            ]);
        }

        $user = Auth::user();

        $abilities = ['user'];
        if ($user->role === 'admin') {
            $abilities = ['user', 'admin'];
        }
        $token = $user->createToken('auth_token', $abilities)->plainTextToken;

        return response()->json([
            "uid" => $user->id,
            "success" => true,
            "message" => "Login successfully",
            "token" => $token,
            "abilities" => $abilities,
        ]);
    }
    function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json([
            "success" => true,
            "message" => "Logout successfully"
        ], 200);
    }
}
