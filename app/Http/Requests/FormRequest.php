<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start : base FormRequest
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as HttpFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class FormRequest extends HttpFormRequest
{
    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $errors = (new ValidationException($validator))->errors();
            $firstError = (collect(array_values($errors))->flatten()->first());
            throw new HttpResponseException(
                responseErrorAPI(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    ERROR_CODE_VALIDATE_FAIL,
                    $firstError,
                )
            );
        }

        parent::failedValidation($validator);
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
