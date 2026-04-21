<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\JobAddCategoryRequest;
use App\Http\Requests\Job\JobAddSkillRequest;
use App\Http\Requests\Job\JobRequest;
use App\Http\Requests\Job\SaveJobRequest;
use App\Http\Resources\Job\JobCollection;
use App\Http\Resources\Job\JobResource;
use App\Models\Category;
use App\Models\Job;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        Log::info('Jobs retrieved successfully');
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
            Log::info('Job created successfully', [
                'user_id' => $request->user()->id,
                'job_id' => $job->id
            ]);
            return (new JobResource($job))
                ->response()
                ->setStatusCode(201);
        }
        Log::alert('Unauthorized user attempt. Job:store', [
            'user_id' => $request->user()->id,
            'job_id' => $request['job_id']
        ]);
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
            Log::alert('Job not found', [
                'job_id' => $id
            ]);
            return response()->json([
                "success" => false,
                "message" => "Job not found"
            ], 404);
        }
        Log::info('Job retrieved successfully', [
            'job_id' => $id
        ]);
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
            if ($job->user_id === $request->user()->id) {
                $job->update($request->validated());
                Log::info('Job updated successfully', [
                    'job_id' => $id,
                    'user_id' => $request->user()->id
                ]);
                return response()->json([
                    "success" => true,
                    "data" => $job,
                ], 200);
            }

        } catch (ModelNotFoundException $e) {
            Log::alert('Job not found', [
                'job_id' => $id
            ]);
            return response()->json([
                "success" => false,
                "message" => "Job not found"
            ], 404);
        }
        Log::alert('Unauthorized user attempt. Job:update', [
            'user_id' => $request->user()->id,
            'job_id' => $id
        ]);
        return response()->json([
            'message' => 'Unauthorized'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $job = Job::findOrFail($id);
            if ($job->user_id === $request->user()->id) {
                $job->delete();
                Log::info('Job deleted successfully', [
                    'job_id' => $id,
                    'user_id' => $request->user()->id
                ]);
                return response()->json([], 204);
            }
        } catch (ModelNotFoundException $e) {
            Log::alert('Job not found', [
                'user_id' => $request->user()->id,
                'job_id' => $id
            ]);
            return response()->json([
                "success" => false,
                "message" => "Job not found"
            ], 404);
        }

    }
    public function addCategory(JobAddCategoryRequest $request) {
        $job = Job::findOrFail($request->job_id);
        if ($request->user()->id === $job->user_id) {
            $job->categories()->attach($request->category_id);
            Log::info('Category added successfully', [
                'job_id' => $request->job_id,
                'user_id' => $request->user()->id,
                'category_id' => $request->category_id
            ]);
            return response()->json([
                "message" => "Category added successfully",
            ], 201);
        }
        Log::alert('Unauthorized user attempt. job:addCategory', [
            'user_id' => $request->user()->id,
            'job_id' => $job->id,
            'category_id' => $request->category_id
        ]);
        return response()->json([
            'message' => 'Unauthorized'
        ]);
    }
    public function removeCategory(Job $job, Category $category, Request $request) {
        if ($request->user()->id === $job->user_id) {
            $job->categories()->detach($category->id);
            Log::info('Category removed successfully', [
                'job_id' => $request->job_id,
                'user_id' => $request->user()->id,
                'category_id' => $request->category_id
            ]);
            return response()->json([
                "message" => "Category removed successfully",
            ], 204);
        }
        Log::alert('Unauthorized user attempt. job:removeCategory', [
            'job_id' => $request->job_id,
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id
        ]);
        return response()->json([
            'message' => 'Unauthorized'
        ]);
    }
    public function addSkill(JobAddSkillRequest $request) {
        $job = Job::findOrFail($request->job_id);
        if ($request->user()->id === $job->user_id) {
            $job->required_skills()->attach($request->skill_id);
            Log::info('Skill added successfully', [
                'job_id' => $request->job_id,
                'user_id' => $request->user()->id,
                'skill_id' => $request->skill_id
            ]);
            return response()->json([
                "message" => "Skill added successfully",
            ], 201);
        }
        Log::alert('Unauthorized user attempt. job:addSkill', [
            'user_id' => $request->user()->id,
            'job_id' => $job->id,
            'skill_id' => $request->skill_id
        ]);
        return response()->json([
            'message' => 'Unauthorized'
        ]);
    }
    public function removeSkill(Job $job, Skill $skill, Request $request) {
        if ($request->user()->id === $job->user_id) {
            $job->required_skills()->detach($skill->id);
            Log::info('Skill removed successfully', [
                'job_id' => $request->job_id,
                'user_id' => $request->user()->id,
                'skill_id' => $request->skill_id
            ]);
            return response()->json([
                "message" => "Skill removed successfully",
            ], 204);
        }
        Log::alert('Unauthorized user attempt. job:removeSkill', [
            'job_id' => $request->job_id,
            'user_id' => $request->user()->id,
            'skill_id' => $request->skill_id
        ]);
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
    public function saveJob(SaveJobRequest $request) {
        $request->user()->saved_jobs()->attach($request->job_id);
        Log::info('Job saved successfully', [
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
                Log::alert('Unauthorized user attempt. job:getApplications', [
                    'user_id' => $request->user()->id,
                    'job_id' => $jobID
                ]);
                return response()->json([
                    "success" => false,
                    "message" => "Unauthorized"
                ], 401);
            }
        } catch (ModelNotFoundException $e) {
            Log::alert('Job not found', [
                'job_id' => $jobID,
                'user_id' => $request->user()->id
            ]);
            return response()->json([
                "success" => false,
                "message" => "Job not found"
            ], 404);
        }
        Log::info('Job applications retrieved successfully', [
            'job_id' => $jobID,
            'user_id' => $request->user()->id
        ]);
        return (new JobResource($job))
            ->response()
            ->setStatusCode(200);
    }

    public function fireUser(Request $request, Job $job, User $user)
    {
        if ($request->user()->id === $job->user_id) {
            $job->workers()->detach($user->id);
            $user->workplaces()->detach($job->id);
            Log::info('User fired from job', [
                'owner' => $request->user()->id,
                'worker' => $user->id,
                'job' => $job->id
            ]);
            return response()->json([
                "message" => "Worker successfully fired"
            ]);
        }
        Log::alert('Unauthorized user attempt. job:fireUser', [
            'user_id' => $request->user()->id,
            'job_id' => $job->id
        ]);
        return response()->json([
            "message" => "Unauthorized"
        ], 401);
    }
    public function unsaveJob(Request $request, Job $job) {
        $request->user()->saved_jobs()->detach($job->id);
        Log::alert('Job unsaved successfully', [
            'user_id' => $request->user()->id,
            'job_id' => $job->id
        ]);
        return response()->json([
            "message" => "Job removed from saved successfully",
        ], 201);
    }
}
