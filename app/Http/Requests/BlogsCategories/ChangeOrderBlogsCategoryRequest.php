<?php
namespace App\Http\Requests\BlogsCategories;

use App\Http\Requests\FormRequest;
use App\Models\NewsCategory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ChangeOrderBlogsCategoryRequest extends FormRequest
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
            ERROR_CODE_INTERNAL_SERVER_ERROR,
            ERROR_CODE_INTERNAL_SERVER_ERROR,
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
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:blogs_categories,id',
            'items.*.order' => 'required|integer|exists:blogs_categories,order',
            'items.*.index' => 'required|integer|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'items.required' => '項目リストは必須です。',
            'items.array' => '項目リストは配列である必要があります。',
            'items.*.id.required' => '各項目にIDが必要です。',
            'items.*.id.integer' => 'IDは整数である必要があります。',
            'items.*.id.exists' => '指定されたIDのカテゴリーが存在しません。',
            'items.*.order.required' => '各項目にIDが必要です。',
            'items.*.order.integer' => 'IDは整数である必要があります。',
            'items.*.order.exists' => '指定されたIDのカテゴリーが存在しません。',
            'items.*.index.required' => '各項目に順序が必要です。',
            'items.*.index.integer' => '順序は整数である必要があります。',
        ];
    }
}
