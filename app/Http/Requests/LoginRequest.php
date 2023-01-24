<?php

namespace App\Http\Requests;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    use ApiResponseTrait;

    public function rules(): array
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation($validator)
    {
        if ($this->expectsJson() && $validator->fails()) {
            $response = $this->errorResponse($validator->errors(), "Please check your input!", 422);
            throw (new ValidationException($validator, $response))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
