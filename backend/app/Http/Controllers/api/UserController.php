<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Resources\Job\JobCollection;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
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
    public function show(string $id)
    {
        try {
            $user = User::with([
                'workplaces',
                'published_jobs',
                'sent_ratings',
                'skills'
            ])->findOrFail($id);
        } catch(ModelNotFoundException) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        return (new UserResource($user))
            ->response()
            ->setStatusCode(200);
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
                return response()->json([
                    "message" => "User updated successfully"
                ]);
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
        } else {
            return response()->json([
                "message" => "Unauthorized"
            ], 401);
        }
    }
    public function showAdmin(Request $request, string $id) {
        if ($request->user()->tokenCan('admin')) {
            try {
                $user = User::with([
                    'workplaces',
                    'saved_jobs',
                    'published_jobs',
                    'received_notifications',
                    'sent_ratings',
                    'skills'
                ])->findOrFail($id);
            } catch (ModelNotFoundException) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }
            return (new UserResource($user))
                ->response()
                ->setStatusCode(200);
        }
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
    public function savedJobs(Request $request) {
        return (new JobCollection($request->user()->saved_jobs()->with([
            'owner',
            'categories',
            'workers',
            'required_skills'
        ])->get()))
            ->response()
            ->setStatusCode(200);
    }
}
