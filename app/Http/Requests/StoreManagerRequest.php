<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManagerRequest extends FormRequest
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
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:8'],
            'phone'       => ['required', 'unique:users,phone', 'regex:/^01[0-9]{9}$/'],
            'image'       => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'address'     => ['required', 'string'],
            'birth_date'   => ['required', 'date', 'before:today'],
            'gender'      => ['required', 'in:male,female'],
        ];
    }



    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Phone Number',
            'address' => 'Address',
            'birth_date' => 'Birth Date',
            'gender' => 'Gender',
        ];
    }
}
