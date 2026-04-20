<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobApplication\JobApplicationRequest;
use App\Http\Resources\JobApplication\JobApplicationCollection;
use App\Http\Resources\JobApplication\JobApplicationResource;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->tokenCan('admin')) {
            $applications = JobApplication::with(['sender', 'receiver'])
                ->get();
        } else if ($request->user()->tokenCan('user')) {
            $applications = JobApplication::with(['sender', 'receiver'])
                ->where('user_id', $request->user()->id)
                ->get();
        } else {
            return response()
                ->json([
                    "message" => "Unauthorized"
                ], 401);
        }
        return (new JobApplicationCollection($applications))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobApplicationRequest $request)
    {
        if ($request->user()->tokenCan('user')) {
            $application = JobApplication::create($request->all());
            return (new JobApplicationResource($application))
                ->response()
                ->setStatusCode(201);
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
    public function show(string $id, Request $request)
    {
        try {
            $application = JobApplication::with(['sender', 'receiver'])->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()
                ->json([
                    "message" => "Job Application not found"
                ], 404);
        }
        if ($request->user()->tokenCan('admin') || $request->user()->id === $application->user_id) {
            return (new JobApplicationResource($application))
                ->response()
                ->setStatusCode(200);
        } else {
            return response()->json([
                "message" => "Unauthorized"
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationRequest $request, string $id)
    {
        try {
            $application = JobApplication::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()
                ->json([
                    "message" => "Job Application not found"
                ], 404);
        }
        if ($request->user()->id === $application->user_id) {
            $application->update($request->validated());
            return response()->json([
                "message" => "Job Application updated successfully"
            ], 200);
        } else {
            return response()
                ->json([
                    "message" => "Unauthorized"
                ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            $application = JobApplication::findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json([
                'message' => 'Model not found'
            ], 404);
        }
        if ($request->user()->tokenCan('admin') || $request->user()->id === $application->user_id) {
            $application->delete();
            return response()->json([], 204);
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }
    public function acceptApplication(Request $request, string $applicationID) {
        try {
            $application = JobApplication::findOrFail($applicationID);
            $user = User::findOrFail($application->user_id);
            $job = $application->receiver;
        } catch (ModelNotFoundException) {
            return response()->json([
                "message" => "Application not found"
            ], 404);
        }
        if ($request->user()->id === $job->user_id) {
            $application->update([
                'status' => 'accepted'
            ]);
            $job->workers()->attach($application->user_id);
            $user->workplaces()->attach($job->id);
            $application->delete();
            return response()->json([
                "message" => 'Application accepted successfully'
            ]);
        }
        return response()->json([
            "message" => "Unauthorized"
        ], 401);
    }
    public function rejectApplication(Request $request, string $applicationID) {
        try {
            $application = JobApplication::findOrFail($applicationID);
        } catch (ModelNotFoundException) {
            return response()->json([
                "message" => "Application not found"
            ], 404);
        }
        $application->delete();
        return response()->json([
            "message" => "Application rejected"
        ]);
    }
}
