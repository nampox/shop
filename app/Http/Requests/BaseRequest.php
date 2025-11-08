<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Constants\Message;
use App\Helpers\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Base Form Request class for all custom requests.
 * 
 * Provides common validation error handling for both JSON and web responses.
 */
abstract class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * By default, all requests are authorized. Override this method
     * in child classes to implement custom authorization logic.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     * 
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     * 
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(
                ResponseHelper::validationError(
                    $validator->errors(),
                    Message::VALIDATION_ERROR
                )
            );
        }

        parent::failedValidation($validator);
    }
}

