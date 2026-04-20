<?php

namespace App\Http\Resources\Notification;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'to' => new UserResource($this->whenLoaded('to')),
            'from' => new UserResource($this->whenLoaded('from')),
            'message' => $this->message,
            'type' => $this->type,
            'is_read' => $this->is_read
        ];
    }
}
