<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
                'user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                    // يمكنك إضافة المزيد من حقول المستخدم إذا أردت
                ],
                'tour' => [
                    'id' => $this->tour->id,
                    'name' => $this->tour->name,
                    'description' => $this->tour->description,
                    'price' => $this->tour->price,
                    // يمكنك إضافة المزيد من حقول الجولة إذا أردت
                ],
                'number_of_people' => $this->number_of_people,
                'number_of_children' => $this->number_of_children,
                'reservation_number' => $this->reservation_number,
                'reservation_date' => $this->reservation_date,
                'created_at' => $this->created_at->toDateTimeString(),
                'updated_at' => $this->updated_at->toDateTimeString(),
            ];
        }    
}
