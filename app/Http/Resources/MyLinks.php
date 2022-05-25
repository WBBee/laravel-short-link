<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyLinks extends JsonResource
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
            'title' => $this->title,
            'shorten_url' => $this->shorten_url,
            'destination_url' => $this->destination_url,
            'created_at' => $this->created_at,
            'perclicks_count' => $this->perclicks_count,
        ];
    }
}
