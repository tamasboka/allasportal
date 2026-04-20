<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\RatingRequest;
use App\Http\Resources\Rating\RatingCollection;
use App\Http\Resources\Rating\RatingResource;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->tokenCan('admin')) {
            $ratings = Rating::with([
                'rater',
                'rated'
            ])->get();
            return (new RatingCollection($ratings))
                ->response()
                ->setStatusCode(200);
        }
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RatingRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        Rating::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        if ($request->user()->tokenCan('admin')) {
            $rating = Rating::with([
                'rater',
                'rated'
            ])->findOrFail($id);
            return (new RatingResource($rating))
                ->response()
                ->setStatusCode(200);
        }
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RatingRequest $request, Rating $rating)
    {
        if ($request->user()->id === $rating->rater()->id) {
            $validated = $request->validated();
            $rating->update($validated);
        }
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $rating = Rating::findOrFail($id);
        if ($request->user()->id === $rating->rater_user_id || $request->user()->role === 'admin') {
            $rating->delete();
            return response(null, 204);
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }
}
