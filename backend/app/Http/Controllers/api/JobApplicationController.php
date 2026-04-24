<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobApplication\JobApplicationRequest;
use App\Http\Resources\JobApplication\JobApplicationCollection;
use App\Http\Resources\JobApplication\JobApplicationResource;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->tokenCan('admin')) {
            $applications = JobApplication::with([
                'sender',
                'receiver'
            ])->get();
            Log::info('Job applications retrieved successfully.', [
                'user_id' => $request->user()->id
            ]);
            return (new JobApplicationCollection($applications))
                ->response()
                ->setStatusCode(200);
        }
        Log::alert('Unauthorized user attempt. JobApplications:index', [
            'user_id' => $request->user()->id
        ]);
        return response()->json([
            'message' => 'Forbidden'
        ], 403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobApplicationRequest $request)
    {
        $application = JobApplication::create([
            'job_id' => $request->job_id,
            'user_id' => $request->user()->id,
            'message' => $request->message
        ]);
        $job = Job::findOrFail($request->job_id);
        $user = User::findOrFail($job->user_id);
        Notification::create([
            'to_user_id' => $user->id,
            'from_user_id' => $request->user()->id,
            'title' => 'Új jelentkező!',
            'message' => $request->user()->firstname . ' jelentkezett a(z) ' . $job->name . ' pozícióra. Ez a levél automatikusan generált.',
            'type' => 'accept'
        ]);
        Log::info('Job application created successfully.', [
            'user_id' => $request->user()->id,
            'job_id' => $request['job_id']
        ]);
        return (new JobApplicationResource($application))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        try {
            $application = JobApplication::with(['sender', 'receiver'])->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Log::alert('Job application not found.', [
                'user_id' => $request->user()->id,
                'application_id' => $id
            ]);
            return response()
                ->json([
                    "message" => "Job Application not found"
                ], 404);
        }
        if ($request->user()->tokenCan('admin') || $request->user()->id === $application->user_id) {
            Log::info('Job application retrieved successfully.', [
                'user_id' => $request->user()->id,
                'application_id' => $id
            ]);
            return (new JobApplicationResource($application))
                ->response()
                ->setStatusCode(200);
        } else {
            Log::alert('Unauthorized user attempt. JobApplications:show', [
                'user_id' => $request->user()->id,
                'application_id' => $id
            ]);
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
            Log::alert('Job application not found.', [
                'user_id' => $request->user()->id,
                'application_id' => $id
            ]);
            return response()
                ->json([
                    "message" => "Job Application not found"
                ], 404);
        }
        if ($request->user()->id === $application->user_id) {
            $application->update($request->validated());
            Log::info('Job application updated successfully.', [
                'user_id' => $request->user()->id,
                'application_id' => $id
            ]);
            return response()->json([
                "message" => "Job Application updated successfully"
            ], 200);
        }
        Log::alert('Unauthorized user attempt. JobApplications:update', [
            'user_id' => $request->user()->id,
            'application_id' => $id
        ]);
        return response()
            ->json([
                "message" => "Unauthorized"
            ], 401);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            $application = JobApplication::findOrFail($id);
        } catch (ModelNotFoundException) {
            Log::info('Job application not found.', [
                'user_id' => $request->user()->id,
                'application_id' => $id
            ]);
            return response()->json([
                'message' => 'Model not found'
            ], 404);
        }
        if ($request->user()->tokenCan('admin') || $request->user()->id === $application->user_id) {
            $application->delete();
            Log::info('Job application deleted successfully.', [
                'user_id' => $request->user()->id,
                'application_id' => $id
            ]);
            return response()->json([], 204);
        }
        Log::alert('Unauthorized user attempt. JobApplications:destroy', [
            'user_id' => $request->user()->id,
            'application_id' => $id
        ]);
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);

    }

    public function acceptApplication(Request $request, JobApplication $application)
    {
        try {
            $user = User::findOrFail($application->user_id);
            $job = $application->receiver;
        } catch (ModelNotFoundException) {
            Log::alert('Job application not found.', [
                'user_id' => $request->user()->id,
                'application_id' => $application->id
            ]);
            return response()->json([
                "message" => "Application not found"
            ], 404);
        }
        if ($request->user()->id === $job->user_id) {
            $application->update([
                'status' => 'accepted'
            ]);
            $job->workers()->attach($user->id);
            Notification::create([
                'to_user_id' => $user->id,
                'from_user_id' => $request->user()->id,
                'title' => 'Elfogadva!',
                'message' => 'Örömmel közöljuk, hogy ' . $request->user()->firstname . ' elfogadta a jelentkezését az ' . $job->name . ' állásra! Ez a levél automatikusan generált.',
                'type' => 'accept'
            ]);
            $application->delete();
            Log::info('Job application accepted successfully.', [
                'receiver' => $request->user()->id,
                'sender' => $application->user_id,
                'application_id' => $application->id
            ]);
            return response()->json([
                "message" => 'Application accepted successfully'
            ]);
        }
        Log::alert('Unauthorized user attempt. JobApplications:accept', [
            'user_id' => $request->user()->id,
            'application_id' => $application->id
        ]);
        return response()->json([
            "message" => "Unauthorized"
        ], 401);
    }

    public function rejectApplication(Request $request, JobApplication $application)
    {
        $job = Job::findOrFail($application->job_id);
        if ($request->user()->id === $job->user_id) {
            Notification::create([
                'to_user_id' => $application->user_id,
                'from_user_id' => $request->user()->id,
                'title' => 'Elutasítva!',
                'message' => 'Sajnálattal közöljuk, hogy ' . $request->user()->firstname . ' elutasította a jelentkezését az ' . $job->name . ' állásra! Ez a levél automatikusan generált.',
                'type' => 'reject'
            ]);
            $application->delete();
            Log::info('Job application rejected successfully.', [
                'receiver' => $request->user()->id,
                'sender' => $application->user_id,
                'application' => $application->id,
            ]);
            return response()->json([
                "message" => "Application rejected"
            ]);
        }
        Log::alert('Unauthorized user attempt. JobApplications:reject', [
            'user_id' => $request->user()->id,
            'application_id' => $application->id
        ]);
        return response()->json([
            "message" => "Unauthorized"
        ], 401);
    }
}
