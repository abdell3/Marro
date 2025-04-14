<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VotePollRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'option_id' => 'required|exists:poll_options,id',
        ];
    }
}