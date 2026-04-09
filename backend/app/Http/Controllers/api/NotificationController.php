<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Http\Resources\Notification\NotificationCollection;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Notification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->tokenCan('user')) {
            $notifications = Notification::where('to_user_id', $request->user()->id)->with(['from'])->get();
            return (new NotificationCollection($notifications))
                ->response()
                ->setStatusCode(200);
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationRequest $request)
    {
        if ($request->user()->tokenCan('user')) {
            $validated = $request->validated();
            $notif = Notification::create($validated);
            return response()->json([
                $notif => new NotificationResource($notif)
            ], 201);
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
        try {
            $notification = Notification::with(['to', 'from'])->findOrFail($id);
            if ($request->user()->tokenCan('user') && ($request->user()->id === $notification->to_user_id || $request->user()->id === $notification->from_user_id)) {
                if ($request->user()->role !== "admin" && $notification->from_user_id !== $request->user()->id) {
                    $notification->update(['is_read' => 1]);
                }
            } else {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }
            return (new NotificationResource($notification))
                ->response()
                ->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Notification not found'
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
    public function destroy(string $id, Request $request)
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->delete();
            return response()->json([], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Notification not found'
            ], 404);
        }
    }
}
