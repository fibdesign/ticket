<?php

namespace Fibdesign\Ticket\requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required',
            'user' => 'nullable'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
