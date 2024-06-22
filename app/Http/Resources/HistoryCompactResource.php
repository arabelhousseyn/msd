<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Activitylog\Models\Activity;

/** @mixin Activity */
class HistoryCompactResource extends JsonResource
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
            'context' => $this->log_name,
            'event' => $this->event,
            'causer_name' => $this->causer?->full_name,
            'properties' => $this->properties,
            'created_at' => $this->created_at->toDateString(),
            'updated_at' => $this->updated_at,
        ];
    }
}
