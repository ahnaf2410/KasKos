<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roomId = $this->route('room');

        return [
            'room_number' => [
                'required',
                'max:20',
                Rule::unique('rooms', 'room_number')->ignore($roomId),
            ],
            'floor' => 'required|integer|min:1',
            'rental_price' => 'required|numeric|min:0',
            'status' => 'required|in:vacant,occupied',
            'description' => 'nullable|string',
        ];
    }
}