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
    public function toArray($request) {
        return [
            'id' => $this->id,
            'firtName' => $this->firtName,
            'middleName' => $this->middleName,
            'lastName' => $this->lastName,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'passwordHash' => $this->passwordHash,
        ];
    }
}
