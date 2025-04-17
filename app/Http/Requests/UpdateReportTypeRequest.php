<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReportTypeRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->hasRole('Admin');
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('report_types')->ignore($this->route('report_type')),
            ],
            'description' => 'nullable|string',
        ];
    }
}