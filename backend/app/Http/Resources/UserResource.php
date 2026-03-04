<?php

namespace App\Http\Resources;

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
            'password' => $this->password,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
            'role' => $this->role,
            'phone' => $this->phone,
            'work_experience' => $this->work_experience,
            'bio' => $this->bio
        ];
    }
}
