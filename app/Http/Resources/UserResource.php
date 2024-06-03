<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
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
            'avatar' => $this->avatar,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'is_admin' => $this->is_admin,
            'is_external' => $this->is_external,
            'company_id' => $this->company_id,
            'company' => CompanyCompactResource::make($this->whenLoaded('company')),
            'email' => $this->email,
            'position' => $this->position,
            'role' => $this->role,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
