<?php

namespace App\Http\Requests;

use App\Http\Helpers\ResponseFormatter;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;

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

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $errorMessage = implode(' ', $errors->all());
        $customResponse = [
            'meta' => [
                'code' => JsonResponse::HTTP_BAD_REQUEST,
                'status' => 'error',
                'message' => $errorMessage,
            ],
            'data' => null,
            'errors' => $errors,
        ];

        throw new HttpResponseException(response()->json($customResponse, JsonResponse::HTTP_BAD_REQUEST));;
    }
}
