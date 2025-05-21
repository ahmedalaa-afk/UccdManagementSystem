<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManagerRequest extends FormRequest
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
            'name'        => ['nullable', 'string', 'max:255'],
            'email'       => ['nullable', 'email', 'exists:users,email'],
            'password'    => ['nullable', 'string', 'min:8'],
            'phone'       => ['nullable', 'regex:/^01[0-9]{9}$/'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'address'     => ['nullable', 'string'],
            'birth_date'   => ['nullable', 'date', 'before:today'],
            'gender'      => ['nullable', 'in:male,female'],
        ];
    }
}
