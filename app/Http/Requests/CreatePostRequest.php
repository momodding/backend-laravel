<?php

namespace App\Http\Requests;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreatePostRequest extends FormRequest
{
    use ApiResponseTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:25',
            'post' => 'required|string|max:255',
        ];
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
