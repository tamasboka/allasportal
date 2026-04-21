<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\EditNotificationRequest;
use App\Http\Requests\Notification\NotificationRequest;
use App\Http\Resources\Notification\NotificationCollection;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->tokenCan('admin')) {
            $notifications = Notification::with([
                'to',
                'from'
            ])->get();
            Log::info('All notifications fetched', [
                'user_id' => $request->user()->id,
            ]);
            return (new NotificationCollection($notifications))
                ->response()
                ->setStatusCode(200);
        } else {
            Log::alert('Unauthorized user attempt. notifications:index', [
                'user_id' => $request->user()->id,
            ]);
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
        $validated = $request->validated();
        if ($request->user()->role === 'user') $validated['type'] = 'general';
        $validated['to_user_id'] = User::where('email', $request->email)->first()->id;
        $validated['from_user_id'] = $request->user()->id;
        $notif = Notification::create($validated);
        Log::info('Notification created', [
            'user_id' => $request->user()->id,
            'notification_id' => $notif->id,
        ]);
        return (new NotificationResource($notif))
            ->response()
            ->setStatusCode(201);
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
                Log::alert('Unauthorized user attempt. notifications:show', [
                    'user_id' => $request->user()->id,
                    'notification_id' => $id,
                ]);
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }
            Log::info('Notification fetched', [
                'user_id' => $request->user()->id,
                'notification_id' => $id,
            ]);
            return (new NotificationResource($notification))
                ->response()
                ->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            Log::alert('Notification not found', [
                'user_id' => $request->user()->id,
                'notification_id' => $id,
            ]);
            return response()->json([
                'message' => 'Notification not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditNotificationRequest $request, Notification $notification)
    {
        if ($request->user()->id === $notification->to_user_id) {
            Log::info('Notification updated', [
                'user_id' => $request->user()->id,
                'notification_id' => $notification->id
            ]);
            $notification->update($request->validated());
            return (new NotificationResource($notification))
                ->response()
                ->setStatusCode(200);
        }
        Log::alert('Unauthorized user action. notification:update', [
            'user_id' => $request->user()->id,
            'notification_id' => $notification->id
        ]);
        return response()->json([
            'Unauthorized'
        ], 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            $notification = Notification::findOrFail($id);
            if ($request->user()->tokenCan('admin') || $request->user()->id === $notification->from_user_id) {
                $notification->delete();
            } else {
                Log::alert('Unauthorized user attempt. notifications:destroy', [
                    'user_id' => $request->user()->id,
                    'notification_id' => $id,
                ]);
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }
            Log::info('Notification deleted', [
                'user_id' => $request->user()->id,
                'notification_id' => $id,
            ]);
            return response()->json([], 204);
        } catch (ModelNotFoundException $e) {
            Log::alert('Notification not found', [
                'user_id' => $request->user()->id,
                'notification_id' => $id,
            ]);
            return response()->json([
                'message' => 'Notification not found'
            ], 404);
        }
    }
}
