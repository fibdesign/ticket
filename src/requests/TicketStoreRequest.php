<?php

namespace Fibdesign\Ticket\requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketStoreRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'subject' => 'required',
            'priority' => 'required',
            'category_id' => 'nullable',
            'user_id' => 'nullable',
            'assigned_to' => 'nullable'
        ];

        $extraFields = config('ticket.extraFields');

        foreach ($extraFields as $field => $value){
            $rules[$field] = $value;
        }

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
