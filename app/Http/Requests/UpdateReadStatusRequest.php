<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReadStatusRequest extends FormRequest
{
    public function rules()
    {
        return [
            'isRead' => 'required|boolean',
        ];
    }
}
