<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\RatingRequest;
use App\Http\Requests\Rating\EditRatingRequest;
use App\Http\Resources\Rating\RatingCollection;
use App\Http\Resources\Rating\RatingResource;
use App\Models\Job;
use App\Models\Notification;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            Log::info('All ratings fetched', [
                'user_id' => $request->user()->id,
            ]);
            return (new RatingCollection($ratings))
                ->response()
                ->setStatusCode(200);
        }
        Log::alert('Unauthorized user attempt. rating:index', [
            'user_id' => $request->user()->id,
        ]);
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
        $job = Job::findOrFail($request->job_id);
        $validated['user_id'] = $request->user()->id;
        $ratedUser = $job->owner;
        $rater = User::findOrFail($request->user()->id);
        Notification::create([
            'to_user_id' => $ratedUser->id,
            'from_user_id' => $request->user()->id,
            'title' => 'Új értékelés!',
            'message' => $rater->firstname . ' ' . $rater->lastname . ' értékelést írt a ' . $job->name . ' állásról! Ez a levél automatikusan generált.',
            'type' => 'general'
        ]);
        $rating = Rating::create($validated);
        Log::info('Rating created', [
            'user_id' => $request->user()->id,
            'rating_id' => $rating->id,
        ]);
        return (new RatingResource($rating))
            ->response()
            ->setStatusCode(201);
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
            Log::info('Rating fetched', [
                'user_id' => $request->user()->id,
                'rating_id' => $id,
            ]);
            return (new RatingResource($rating))
                ->response()
                ->setStatusCode(200);
        }
        Log::alert('Unauthorized user attempt. rating:show', [
            'user_id' => $request->user()->id,
            'rating_id' => $id,
        ]);
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRatingRequest $request, Rating $rating)
    {
        if ($request->user()->id === $rating->rater()->id) {
            $validated = $request->validated();
            $rating->update($validated);
            Log::info('Rating updated', [
                'user_id' => $request->user()->id,
                'rating_id' => $rating->id
            ]);
            return (new RatingResource($rating))
                ->response()
                ->setStatusCode(200);
        }
        Log::alert('Unauthorized user attempt. rating:update', [
            'user_id' => $request->user()->id,
            'rating_id' => $rating->id,
        ]);
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
        if ($request->user()->id === $rating->user_id || $request->user()->role === 'admin') {
            $rating->delete();
            Log::alert('Rating deleted', [
                'user_id' => $request->user()->id,
                'rating_id' => $id,
            ]);
            return response()->json([], 204);
        }
        Log::alert('Unauthorized user attempt. ratings:destroy', [
            'user_id' => $request->user()->id,
            'rating_id' => $id,
        ]);
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
}
