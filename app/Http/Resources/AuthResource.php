<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'email' => $this->email,
            'full_name' => $this->full_name,
            'username' => $this->username,
            'profile_image_url' => $this->profile_image_url,
            'age' => $this->age,
            'phone_number' => $this->phone_number
        ];
    }
}
