<?php

namespace App\Http\Requests\Sendmail;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SendInquiryTestMailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Implement your authorization logic here
        // For example, check if the user owns the news article or has the right permissions
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        $errorString = implode("\n", $errors);
        throw new HttpResponseException(responseErrorAPI(
            null,
            ERROR_CODE_VALIDATE_FAIL,
            ERROR_CODE_VALIDATE_FAIL,
            $errorString
        ));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'smtp_server' => 'required',
            'smtp_port_number' => 'required|integer',
            'smtp_account_name' => 'required',
            'smtp_password' => 'required',
            'dest_mailaddress' => '',
            'from_mailaddress' => '',

            // 'items' => 'required|array',
            // 'items.*.id' => 'required|integer|exists:tags,id',
            // 'items.*.order' => 'required|integer|exists:tags,order',
            // 'items.*.index' => 'required|integer|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    public function attributes()
    {
        return [
            'smtp_server' => 'SMTPサーバー',
            'smtp_port_number' => 'SMTPポート番号',
            'smtp_account_name' => 'SMTPアカウント名',
            'smtp_password' => 'SMTPパスワード',
            'dest_mailaddress' => '',
            'from_mailaddress' => '',
        ];
    }
}
