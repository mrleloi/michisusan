<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class UpdateUserRequest extends FormRequest
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
        $user = User::find($this->id);
        return [
            'name' => ['required'],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $user->email . ',email'
            ],
            'password' => [
                'nullable',
                'min:8',
                'max:16',
                Password::min(8)
                    ->max(16)
                    ->mixedCase()
            ],
            'is_manager' => ['boolean'],
        ];
    }

    public function messages()
    {
        return [
            'password.required' => trans('validation.required'),
            'password.max' => trans('validation.max.string'),
            'password.min' => trans('validation.min.string'),
            'password.*' => trans('validation.password_format'),
        ];
    }
}
