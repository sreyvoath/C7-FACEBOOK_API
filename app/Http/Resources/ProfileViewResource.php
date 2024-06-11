<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProfileViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $permissions = $this->getAllPermissions();
        $roles = $this->getRoleNames();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_image' => $this->media ? Storage::url($this->media->profile_image) : "There is no image uplaod yet",
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y'),
            'permissions' => $permissions,
            'roles' => $roles,
        ];
    }
}
