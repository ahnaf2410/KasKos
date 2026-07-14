<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'room_number'  => $this->room_number,
            'floor'        => $this->floor,
            'rental_price' => $this->rental_price,
            'status'       => $this->status,
            'description'  => $this->description,
            'tenant'       => $this->whenLoaded('tenant', function () {
                if (!$this->tenant) return null;
                return [
                    'id'    => $this->tenant->id,
                    'name'  => $this->tenant->name,
                    'email' => $this->tenant->email,
                ];
            }),
            'created_at'   => $this->created_at?->toIso8601String(),
            'updated_at'   => $this->updated_at?->toIso8601String(),
        ];
    }
}
