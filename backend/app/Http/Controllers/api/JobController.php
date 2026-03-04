<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobRequest;
use App\Http\Resources\JobResource;
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
        return JobResource::collection(Job::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request)
    {
        $job = Job::create($request->validated());
        return response()->json([
            "success" => true,
            "data" => $job,
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $job = Job::findOrFail($id);
        }catch (ModelNotFoundException $e){
            return response()->json([
                "success" => false,
                "message" => "Job not found"
            ],404);
        }
        return response()->json([
            "success" => true,
            "data" => $job,
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobRequest $request, string $id)
    {
        try {
            $job = Job::findOrFail($id);
            $job->update($request->validated());
        }catch (ModelNotFoundException $e){
            return response()->json([
                "success" => false,
                "message" => "Job not found"
            ],404);
        }
        return response()->json([
            "success" => true,
            "data" => $job,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $job = Job::findOrFail($id);
            $job->delete();
        }catch (ModelNotFoundException $e){
            return response()->json([
                "success" => false,
                "message" => "Job not found"
            ],404);
        }
        return response()->json([
            "success" => true,
            "data" => $job,
        ],200);
    }
}
