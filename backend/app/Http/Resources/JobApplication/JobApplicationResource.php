<?php

namespace App\Http\Resources\JobApplication;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "sender" => new UserResource($this->whenLoaded('sender')),
            "receiver" => new UserResource($this->whenLoaded('receiver')),
            "message" => $this->message,
            "status" => $this->status,
            "sent" => $this->created_at
        ];
    }
}
