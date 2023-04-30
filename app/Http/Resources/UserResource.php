<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
          'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar_id' => $this->avatar_id,
            'avatar' => $this->avatar_id ? new ImageResource($this->avatar) : null,
        ];
    }
}