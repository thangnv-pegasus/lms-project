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
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->address,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'class' => $this->class ? new ClassResource($this->class) : null,
            'province_id' => $this->province,
            'district_id' => $this->district,
            'ward_id' => $this->ward,
            'role' => $this->role,
        ];
    }
}
