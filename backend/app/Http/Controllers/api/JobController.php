<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobAddCategoryRequest;
use App\Http\Requests\JobAddSkillRequest;
use App\Http\Requests\JobRequest;
use App\Http\Requests\SaveJobRequest;
use App\Http\Resources\Job\JobCollection;
use App\Http\Resources\Job\JobResource;
use App\Models\Category;
use App\Models\Job;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                'required_skills',
                'ratings.rater'
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
        $job = Job::findOrFail($request->job_id);
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
    public function removeCategory(Job $job, Category $category, Request $request) {
        if ($request->user()->id === $job->user_id) {
            $job->categories()->detach($category->id);
            return response()->json([
                "message" => "Category removed successfully",
            ], 204);
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
    public function removeSkill(Job $job, Skill $skill, Request $request) {
        if ($request->user()->id === $job->user_id) {
            $job->required_skills()->detach($skill->id);
            return response()->json([
                "message" => "Skill removed successfully",
            ], 204);
        }
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
    public function saveJob(SaveJobRequest $request) {
        DB::table('user_saved_jobs')->insert([
            'job_id' => $request->job_id,
            'user_id' => $request->user()->id,
        ]);
        return response()->json([
            "message" => "Job saved successfully",
        ], 201);
    }
    public function getApplications(Request $request, string $jobID) {
        try {
            $job = Job::with([
                'received_applications.sender',
            ])->findOrFail($jobID);
            if ($job->user_id !== $request->user()->id) {
                return response()->json([
                    "success" => false,
                    "message" => "Unauthorized"
                ], 401);
            }
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

    public function fireUser(Request $request, Job $job, User $user)
    {
        if ($request->user()->id === $job->user_id) {
            $job->workers()->detach($user->id);
            return response()->json([
                "message" => "Woker successfully fired"
            ]);
        }
        return response()->json([
            "message" => "Unauthorized"
        ], 401);
    }
}
