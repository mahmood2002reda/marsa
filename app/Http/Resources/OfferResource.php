<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'tour_id' => $this->tour_id,
            'new_price' => $this->new_price,
            'offer_end_date' => $this->offer_end_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'name' => $this->tour->name,
            'description' => $this->tour->description,
            'tour_duration' => $this->tour->tour_duration,
            'images' => $this->tour->images,
            'services' => $this->tour->services,
            'must_know' => $this->tour->must_know,
            'location' => $this->tour->location,
            'type' => $this->tour->type,
            'governorate' => $this->tour->governorate,
            'start_date' => $this->tour->start_date,
            'price' => $this->tour->price,
        ];    }
}
