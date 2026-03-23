<?php

namespace App\Http\Resources\Job;

use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Skill\SkillCollection;
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
            "advertiser" => new UserResource($this->whenLoaded('owner')),
            "name" => $this->name,
            "job_type" => $this->job_type,
            "categories" => new CategoryCollection($this->whenLoaded('categories')),
            "required" => new SkillCollection($this->whenLoaded('required_skills')),
        ];
    }
}
