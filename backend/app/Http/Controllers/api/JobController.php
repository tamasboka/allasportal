<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobAddCategoryRequest;
use App\Http\Requests\JobAddSkillRequest;
use App\Http\Requests\JobRequest;
use App\Http\Resources\Job\JobCollection;
use App\Http\Resources\Job\JobResource;
use App\Models\Job;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::with([
            'owner',
            'categories',
            'required_skills',
            'ratings',
            'workers'
        ])->get();
        return (new JobCollection($jobs))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request)
    {
        if ($request->user()->tokenCan('user')) {
            $validated = $request->validated();
            $validated['user_id'] = $request->user()->id;
            $job = Job::create($validated);
            return response()->json([
                "success" => true,
                "data" => $job,
            ], 201);
        }
        return response()->json([
            "success" => false,
            "message" => "Unauthorized",
        ], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $job = Job::with([
                'owner',
                'categories',
                'workers',
                'required_skills'
            ])->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "success" => false,
                "message" => "Job not found"
            ], 404);
        }
        return (new JobResource($job))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobRequest $request, string $id)
    {
        try {
            $job = Job::findOrFail($id);
            $job->update($request->validated());
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "success" => false,
                "message" => "Job not found"
            ], 404);
        }
        return response()->json([
            "success" => true,
            "data" => $job,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $job = Job::findOrFail($id);
            $job->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "success" => false,
                "message" => "Job not found"
            ], 404);
        }
        return response()->json([
            "success" => true,
            "data" => $job,
        ], 200);
    }
    public function addCategory(JobAddCategoryRequest $request) {
        $job = Job::findOrFail($request->category_id);
        if ($request->user()->id === $job->user_id) {
            $job->categories()->attach($request->category_id);
            return response()->json([
                "message" => "Skill added successfully",
            ], 201);
        }
        return response()->json([
            'message' => 'Unauthorized'
        ]);
    }
    public function addSkill(JobAddSkillRequest $request) {
        $job = Job::findOrFail($request->job_id);
        if ($request->user()->id === $job->user_id) {
            $job->required_skills()->attach($request->skill_id);
            return response()->json([
                "message" => "Skill added successfully",
            ], 201);
        }
        return response()->json([
            'message' => 'Unauthorized'
        ]);
    }
}
