<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->tokenCan('admin')) {
            $users = User::all();
            return (new UserCollection($users))
                ->response()
                ->setStatusCode(200);
        } else {
            return response()
                ->json([
                    "message" => "Unauthorized"
                ], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        try {
            if ($request->user()->id === $id) {
                $user = User::with([
                    'received_ratings',
                    'sent_ratings',
                    'works_at',
                    'saved_jobs',
                    'sent_notifications',
                ])->findOrFail($id);
            } else {
                $user = User::with([
                    'received_ratings',
                    'sent_ratings',
                    'works_at',
                ])->findOrFail($id);
            }

        } catch (ModelNotFoundException $e) {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditUserRequest $request, string $id)
    {
        if ($request->user()->id === $id) {
            $validated = $request->validated();
            try {
                $user = User::findOrFail($id);
                $user->update($validated);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    "message" => "User not found"
                ], 404);
            }
        } else {
            return response()->json([
                "message" => "Unauthorized"
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        if ($request->user()->id === $id || $request->user()->tokenCan('admin')) {
            try {
                $user = User::findOrFail($id);
                $user->delete();
                return response()->json([
                    "message" => "User deleted successfully"
                ]);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    "message" => "User not found"
                ], 404);
            }
        }
    }
}
