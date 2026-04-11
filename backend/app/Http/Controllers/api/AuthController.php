<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);

        return response()->json([
            "success" => true,
            "message" => "Register successfully",
            'user' => $user
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if (!Auth::attempt($validated)) {
            return response()->json([
                "success" => false,
                "message" => "Unauthorized"
            ]);
        }

        $user = Auth::user();

        $role_abilities = [
            'user' => [
                'user'
            ],
            'admin' => [
                'user',
                'admin'
            ]
        ];

        $abilities = $role_abilities[$user->role];
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
    function abilities(Request $request) {
        $abilities = [];
        foreach ($request->user()->tokens() as $token) {
            $abilities[] = $token->abilities;
        }
        return response()->json([
            "role" => $request->user()->role,
        ], 200);
    }
}
