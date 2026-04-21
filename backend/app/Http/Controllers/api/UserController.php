<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Resources\Job\JobCollection;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function Laravel\Prompts\alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->tokenCan('admin')) {
            $users = User::all();
            Log::info('All users fetched', [
                'user_id' => $request->user()->id,
            ]);
            return (new UserCollection($users))
                ->response()
                ->setStatusCode(200);
        }
        Log::alert('Unauthorized user attempt. user:index', [
            'user_id' => $request->user()->id,
        ]);
        return response()
            ->json([
                "message" => "Unauthorized"
            ], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::with([
                'workplaces',
                'published_jobs.workers',
                'sent_ratings',
                'skills'
            ])->findOrFail($id);
        } catch (ModelNotFoundException) {
            Log::alert('User not found', [
                'id' => $id,
            ]);
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        Log::info('User fetched', [
            'id' => $id
        ]);
        return (new UserResource($user))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditUserRequest $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            $validated = $request->validated();
            try {
                $user->update($validated);
                Log::info('User updated', [
                    'user_id' => $request->user()->id,
                    'id' => $user->id
                ]);
                return response()->json([
                    "message" => "User updated successfully"
                ]);
            } catch (ModelNotFoundException $e) {
                Log::alert('User not found', [
                    'user_id' => $request->user()->id,
                ]);
                return response()->json([
                    "message" => "User not found"
                ], 404);
            }
        } else {
            Log::alert('Unauthorized user attempt', [
                'user_id' => $request->user()->id,
                'id' => $user->id
            ]);
            return response()->json([
                "message" => "Unauthorized",
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
                Log::info('User deleted', [
                    'user_id' => $request->user()->id,
                    'id' => $user->id
                ]);
                return response()->json([
                    "message" => "User deleted successfully"
                ]);
            } catch (ModelNotFoundException $e) {
                Log::alert('User not found', [
                    'id' => $user->id
                ]);
                return response()->json([
                    "message" => "User not found"
                ], 404);
            }
        }
        Log::alert('Unauthorized user attempt', [
            'user_id' => $request->user()->id,
            'id' => $id
        ]);
        return response()->json([
            "message" => "Unauthorized"
        ], 401);

    }

    public function showAdmin(Request $request, string $id)
    {
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

    public function savedJobs(Request $request)
    {
        Log::info('Saved jobs retrieved successfully', [
            'user_id' => $request->user()->id,
        ]);
        return (new JobCollection($request->user()->saved_jobs()->with([
            'owner',
            'categories',
            'workers',
            'required_skills'
        ])->get()))
            ->response()
            ->setStatusCode(200);
    }

    public function addSkill(Request $request)
    {
        $request->user()->skills()->attach($request->skill_id);
        Log::info('Skill added successfully to user', [
            'user_id' => $request->user()->id,
            'skill_id' => $request->skill_id
        ]);
        return response()->json([
            "message" => "Skill added successfully"
        ]);
    }

    public function removeSkill(Request $request, User $user, Skill $skill)
    {
        $user->skills()->detach($skill->id);
        Log::info('Skill removed successfully from user', [
            'user_id' => $request->user()->id,
            'skill_id' => $request->skill_id
        ]);
        return response()->json([
            "message" => "Skill removed successfully"
        ]);
    }
}
