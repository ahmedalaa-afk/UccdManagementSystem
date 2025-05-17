<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreInstructorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Name' => $this->name,
            'Email' => $this->email,
            'Phone' => $this->phone,
            'Description' => $this->description,
            'username' => $this->username,
            'Role' => $this->roles[0]->name,
            'Image' => $this->image,
        ];
    }
}
