<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Rating' => $this->rating,
            'Review' => $this->review,
            'Created At' => $this->created_at,
            'User' => new UserResource($this->user),
        ];
    }
}
