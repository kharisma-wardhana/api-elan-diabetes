<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class AddAktifitasRequest extends FormRequest
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
            'users_id' => ['required'],
            'jenis' => ['required'],
            'jam' => ['required'],
            'menit' => ['required'],
            'tanggal' => ['required'],
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
