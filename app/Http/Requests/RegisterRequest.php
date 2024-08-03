<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'nama' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'no_hp' => ['required', 'string', 'unique:users'],
            'jenis_kelamin' => ['required'],
            'tanggal_lahir' => ['required'],
        ];
    }
}
