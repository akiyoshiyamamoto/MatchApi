<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetConversationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'partner_id' => ['required', 'integer'],
        ];
    }
}
