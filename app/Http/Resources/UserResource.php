<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "firstName" => $this->first_name,
            "lastName" => $this->last_name,
            "username" => $this->username,
            "email" => $this->email,
            "status" => $this->status,
            "type" => $this->type,
            "emailVerifiedAt" => $this->email_verified_at,
        ];
    }
}
