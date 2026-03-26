<?php

namespace App\Http\Resources\Organization;

use App\Http\Resources\Job\JobCollection;
use App\Http\Resources\User\UserCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
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
            'name' => $this->name,
            'foundation' => $this->founded_at,
            'workers' => new UserCollection($this->whenLoaded('workers')),
            'jobs' => new JobCollection($this->whenLoaded('jobs')),
            'workers_count' => $this->workers_count
        ];
    }
}
