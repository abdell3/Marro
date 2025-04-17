<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportTypeRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->hasRole('Admin');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:report_types',
            'description' => 'nullable|string',
        ];
    }
}