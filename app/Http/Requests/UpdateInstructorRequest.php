<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstructorRequest extends FormRequest
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
            'name' => 'nullable',
            'email' => 'nullable|email',
            'username' => 'nullable',
            'password' => 'nullable|min:8',
            'phone' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
