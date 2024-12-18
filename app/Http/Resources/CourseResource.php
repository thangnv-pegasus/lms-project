<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'slug' => $this->slug,
            'memeber_count' => $this->member_count,
            'department' => $this->whenLoaded('department', $this->department->name) ?? null,
            'lesson' => $this->whenLoaded('lessons', new LessonCollectionResource($this->lessons)) ?? null,
        ];
    }
}
