<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'report_type_id' => 'required|exists:report_types,id',
            'reportable_type' => 'required|string|in:App\\Models\\Post,App\\Models\\Comment,App\\Models\\User,App\\Models\\Community',
            'reportable_id' => 'required|integer',
            'description' => 'nullable|string',
        ];
    }
}
