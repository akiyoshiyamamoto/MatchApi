<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SwipeRightRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'swiped_id' => ['required', 'integer'],
        ];
    }
}
