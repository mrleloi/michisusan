<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePhoneCallRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page_title' => 'nullable|string|max:255',
            'page_location' => 'nullable|string|max:255',
            'page_path' => 'nullable|string|max:255',
            'button_position' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'access_ip' => 'nullable|string|max:255',
            'user_agent' => 'nullable|string',
        ];
    }
}
