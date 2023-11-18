<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:3', 'max:80', Rule::unique('projects')],
            'thumb' => ['nullable', 'image', 'max:1024'],
            'description' => ['nullable', 'string', 'max:300'],
            'type' => ['nullable', 'string', 'max:100'],
            'release_date' => ['nullable', 'string', 'max:100'],
            'github_link' => ['nullable', 'string', 'max:255', Rule::unique('projects')],
            'public_link' => ['nullable', 'string', 'max:255', Rule::unique('projects')],
        ];
    }
}
