<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
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
        $data =  [
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
            'is_external' => $this->is_external,
            'created_at' => $this->created_at->toDateTimeString(),
        ];

	 // Check if the user is authenticated
        // Transform the data conditionally based on authentication status
        // if (!Auth::check()) {
            // Exclude directions and smtp information
        //    unset($data['directions']);
        //    unset($data['smtp']);
        //    unset($data['email']);
        //    unset($data['phone']);
        //    unset($data['address']);
        //    unset($data['created_at']);
        //    unset($data['is_external']);

        //}
        return $data;
    }
}
