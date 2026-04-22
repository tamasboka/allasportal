<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);

        Log::info('New user registered', [
            'user_id' => $user->id,
            'ip' => $request->ip(),
        ]);

        Notification::create([
            'to_user_id' => $user->id,
            'from_user_id' => rand(1, 2),
            'title' => 'Üdv a JobNest-en!',
            'message' => 'Köszönjuk, hogy regisztráltál!',
            'type' => 'accept'
        ]);
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
            Log::alert('Failed login attempt', [
                'ip' => $request->ip()
            ]);
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

        Log::info('User logged in.', [
            'user_id' => $user->id
        ]);
        return response()->json([
            "uid" => $user->id,
            "success" => true,
            "message" => "Login successfully",
            "token" => $token,
            "abilities" => $abilities,
        ]);
    }

    function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        Log::info('User logged out.', [
            'user_id' => $request->user()->id
        ]);
        return response()->json([
            "success" => true,
            "message" => "Logout successfully"
        ], 200);
    }
    function role(Request $request)
    {
        Log::info('User role retrieved', [
            'user_id' => $request->user()->id
        ]);
        return response()->json([
            "role" => $request->user()->role
        ]);
    }

    function me(Request $request)
    {
        $user = User::with([
            'saved_jobs',
            'workplaces',
            'skills',
            'received_notifications.from',
            'received_notifications.to',
            'sent_notifications.from',
            'sent_notifications.to',
        ])
            ->findOrFail($request->user()->id);
        Log::debug('User profile retrieved', [
            'user_id' => $request->user()->id
        ]);
        return (new UserResource($user))
            ->response()
            ->setStatusCode(200);
    }
}
