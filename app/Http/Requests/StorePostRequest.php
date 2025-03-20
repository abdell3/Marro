<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'type' => 'required|in:text,image,video', 
            'content' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:10240', 
            'user_id' => 'required|exists:users,id',
            'thread_id' => 'nullable|exists:threads,id',
            'community_id' => 'required|exists:communities,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];
    }
}
