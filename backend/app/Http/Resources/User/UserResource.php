<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Job\JobCollection;
use App\Http\Resources\Notification\NotificationCollection;
use App\Http\Resources\Organization\OrganizationResource;
use App\Http\Resources\Rating\RatingCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
            'role' => $this->role,
            'phone' => $this->phone,
            'work_experience' => $this->work_experience,
            'bio' => $this->bio,
            'saved_jobs' => new JobCollection($this->whenLoaded('saved_jobs')),
            'received_ratings' => new RatingCollection($this->whenLoaded('received_ratings')),
            //'sent_notifications' => new NotificationCollection($this->whenLoaded('sent_notifications')),
            'received_notifications' => new NotificationCollection($this->whenLoaded('received_notifications')),
            'sent_ratings' => new RatingCollection($this->whenLoaded('sent_ratings')),
            'workplace' => new OrganizationResource($this->whenLoaded('workplace')),
        ];
    }
}
