<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Company */
class CompanyResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'color' => $this->color,
            'description' => $this->description,
            'email' => $this->email,
            'phone' => $this->phone,
            'logo' => $this->logo,
            'address' => $this->address,
            'lang' => $this->lang,
            'smtp' => $this->smtp,
            'directions' => $this->directions,
            'is_external' => $this->is_external
        ];
    }
}
