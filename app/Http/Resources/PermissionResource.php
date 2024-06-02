<?php

namespace App\Http\Resources;

use App\Enums\Permissions;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Permission;

/** @mixin Permission */
class PermissionResource extends JsonResource
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
            'description' => Permissions::getDescription($this->name),
            'guard_name' => $this->guard_name,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
