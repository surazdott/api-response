<?php

namespace SurazDott\ApiResposne\Concerns;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use SurazDott\ApiResponse\Facades\Api;

trait HasApiResponse
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     */
    protected function failedValidation(Validator $validator): HttpResponseException
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(Api::validation($validator->errors()));
        }

        parent::failedValidation($validator);
    }
}
