<?php

namespace App\Http\Resources\Job;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            "advertiser" => $this->owner,
            "name" => $this->name,
            "job_type" => $this->job_type,
            "catrgories" => $this->categories,
            "required" => $this->required_skills
        ];
    }
}
