<?php

namespace Fibdesign\Ticket\requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketMessageStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => 'required',
            'file' => 'nullable',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
