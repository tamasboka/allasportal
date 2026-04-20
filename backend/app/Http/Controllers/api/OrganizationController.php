<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\OrganizationRequest;
use App\Http\Resources\Organization\OrganizationCollection;
use App\Http\Resources\Organization\OrganizationResource;
use App\Models\Organization;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_organizations = Organization::withCount('workers as workers_count')
            //->with(['workers'])
            ->get();
        return (new OrganizationCollection($all_organizations))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrganizationRequest $request)
    {
        if ($request->user()->tokenCan('admin')) {
            $validated = $request->validated();
            $organization = Organization::create($validated);
            return (new OrganizationResource($organization))
                ->response()
                ->setStatusCode(201);
        } else {
            return response()
                ->json([
                    'message' => 'Unauthorized'
                ], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $organization = Organization::with(['workers', 'jobs'])
                ->withCount('workers')
                ->findOrFail($id);
            return (new OrganizationResource($organization))
                ->response()
                ->setStatusCode(200);
        } catch (ModelNotFoundException) {
            return response()
                ->json([
                    'message' => 'Organization not found'
                ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
