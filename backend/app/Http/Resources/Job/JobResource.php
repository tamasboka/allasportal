<?php

namespace App\Http\Resources\Job;

use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\JobApplication\JobApplicationCollection;
use App\Http\Resources\Rating\RatingCollection;
use App\Http\Resources\Skill\SkillCollection;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
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
            "name" => $this->name,
            "job_type" => $this->job_type,
            "capacity" => $this->capacity,
            "type" => $this->type,
            "min_salary" => $this->min_salary,
            "max_salary" => $this->max_salary,
            "description" => $this->description,
            "advertiser" => new UserResource($this->whenLoaded('owner')),
            "applications" => new JobApplicationCollection($this->whenLoaded('received_applications')),
            "categories" => new CategoryCollection($this->whenLoaded('categories')),
            "workers" => new UserCollection($this->whenLoaded('workers')),
            "worker_count" => new UserCollection($this->whenLoaded('workers'))->count(),
            "skills" => new SkillCollection($this->whenLoaded('required_skills')),
            "ratings" => new RatingCollection($this->whenLoaded('ratings')),
        ];
    }
}
