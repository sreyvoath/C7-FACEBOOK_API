<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_react' => $this->user->name,
            'react_type' => $this->react_type,
            'created_at' => $this->created_at->format('d-m-Y'),
        ];
    }
}
