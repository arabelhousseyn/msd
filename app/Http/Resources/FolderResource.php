<?php

namespace App\Http\Resources;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Folder */
class FolderResource extends JsonResource
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
            'title' => $this->title,
            'comment' => $this->comment,
            'notify_before' => $this->notify_before,
            'end_at' => $this->end_at->toDateString(),
            'remaining_days' => $this->remaining_days,
            'user' => UserResource::make($this->whenLoaded('user')),
            'user_id' => $this->user_id,
            'status' => $this->status,
            'documents' => DocumentResource::collection($this->documents),
            'documents_count' => $this->documents()->count(),
            'created_at' => $this->created_at->toDateString(),
            'folder_history' => HistoryCompactResource::collection($this->activities()->with('causer')->get()),
            'document_history' => HistoryCompactResource::collection($this->loadDDocumentHistory()),
        ];
    }
}
