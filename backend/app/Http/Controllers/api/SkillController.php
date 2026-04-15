<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillRequest;
use App\Http\Resources\Skill\SkillCollection;
use App\Http\Resources\Skill\SkillResource;
use App\Models\Skill;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::all();
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
            return (new SkillResource($skill))
                ->response()
                ->setStatusCode(201);
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        if ($request->user()->tokenCan('admin')) {
            try {
                $skill = Skill::findOrFail($id);
                return (new SkillResource($skill))
                    ->response()
                    ->setStatusCode(200);
            } catch (ModelNotFoundException) {
                return response()->json([
                    'message' => 'Model not found'
                ], 404);
            }
        } else {
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
                return response()->json([
                    'message' => 'Model not found'
                ], 404);
            }
            $validated = $request->validated();
            $skill->update($validated);
            return (new SkillResource($skill))
                ->response()
                ->setStatusCode(200);
        } else {
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
                return response()->json([], 204);
            } catch (ModelNotFoundException) {
                return response()->json([
                    'message' => 'Model not found'
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }
}
