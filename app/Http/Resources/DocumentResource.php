<?php

namespace App\Http\Resources;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Document */
class DocumentResource extends JsonResource
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
            'format' => $this->format,
            'size' => $this->size,
            'url' => $this->url,
            'creator' => UserResource::make($this->creator),
            'description' => $this->description,
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
