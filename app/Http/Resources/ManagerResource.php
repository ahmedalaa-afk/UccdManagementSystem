<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagerResource extends JsonResource
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
            'username' => $this->username,
            'Role' => $this->roles[0]->name,
            'Image' => $this->image,
            'Address' => $this->address,
            'Birth Date' => Carbon::parse($this->birth_date)->format('Y-m-d'),
            'Gender' => $this->gender,
            'Permissions' => $this->permissions,
        ];
    }
}
