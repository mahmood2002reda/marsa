<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'translated_name' =>  $this->name, 
            'description' => $this->description,
            'translated_description' => $this->description, 
            'tour_duration' => $this->tour_duration,
            'price' => $this->price,
            'images' => $this->toursImage->map(function($image) {
                return url('images/tour/' . $image->image);
            }) ?? [], // If $this->toursImage is null, use an empty array
            'location' => $this->location,
            'type' => $this->type,
            'start_date' => $this->start_date,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'has_offer' => $this->has_offer,
        ];
}
}