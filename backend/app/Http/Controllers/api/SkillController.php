<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Skill\SkillRequest;
use App\Http\Resources\Skill\SkillCollection;
use App\Http\Resources\Skill\SkillResource;
use App\Models\Skill;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::all();
        Log::debug('ALl skills fetched');
        return (new SkillCollection($skills))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkillRequest $request)
    {
        if ($request->user()->tokenCan('admin')) {
            $validated = $request->validated();
            $skill = Skill::create($validated);
            Log::info('Skill created', [
                'user_id' => $request->user()->id,
                'skill_id' => $skill->id,
            ]);
            return (new SkillResource($skill))
                ->response()
                ->setStatusCode(201);
        }
        Log::alert('Unauthorized user attempt. skill:store', [
            'user_id' => $request->user()->id
        ]);
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        if ($request->user()->tokenCan('admin')) {
            try {
                $skill = Skill::findOrFail($id);
                Log::info('Skill shown', [
                    'user_id' => $request->user()->id,
                    'skill_id' => $id,
                ]);
                return (new SkillResource($skill))
                    ->response()
                    ->setStatusCode(200);
            } catch (ModelNotFoundException) {
                Log::alert('Skill not found', [
                    'user_id' => $request->user()->id,
                    'skill_id' => $id,
                ]);
                return response()->json([
                    'message' => 'Model not found'
                ], 404);
            }
        } else {
            Log::alert('Unauthorized user attempt. skill:show', [
                'user_id' => $request->user()->id,
                'skill_id' => $id
            ]);
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkillRequest $request, string $id)
    {
        if ($request->user()->tokenCan('admin')) {
            try {
                $skill = Skill::findOrFail($id);
            } catch (ModelNotFoundException) {
                Log::alert('Skill not found', [
                    'user_id' => $request->user()->id,
                    'skill_id' => $id,
                ]);
                return response()->json([
                    'message' => 'Skill not found'
                ], 404);
            }
            $validated = $request->validated();
            $skill->update($validated);
            Log::info('Skill updated', [
                'user_id' => $request->user()->id,
                'skill_id' => $id,
            ]);
            return (new SkillResource($skill))
                ->response()
                ->setStatusCode(200);
        } else {
            Log::alert('Unauthorized user attempt. skill:update', [
                'user_id' => $request->user()->id,
                'skill_id' => $id
            ]);
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        if ($request->user()->tokenCan('admin')) {
            try {
                $skill = Skill::findOrFail($id);
                $skill->delete();
                Log::info('Skill deleted', [
                    'user_id' => $request->user()->id,
                    'skill' => $skill->name,
                ]);
                return response()->json([], 204);
            } catch (ModelNotFoundException) {
                Log::alert('Skill not found', [
                    'user_id' => $request->user()->id,
                    'skill_id' => $id,
                ]);
                return response()->json([
                    'message' => 'Model not found'
                ], 404);
            }
        }
        Log::alert('Unauthorized user attempt. skill:destroy', [
            'user_id' => $request->user()->id,
            'skill_id' => $id
        ]);
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
}
