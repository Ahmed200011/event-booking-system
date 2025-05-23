<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->event_name,
            'description' => $this->description,
            'date' => $this->date,
            'location' => $this->location,
            'image' => $this->image,
            'price' => $this->price,
            'status' => $this->status,
           
        ];
    }
}
