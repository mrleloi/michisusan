<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxFullHalfWidth implements Rule
{
    protected $maxLength;

    public function __construct($maxLength = 30)
    {
        $this->maxLength = $maxLength;
    }

    public function passes($attribute, $value)
    {
        return mb_strlen($value, 'UTF-8') <= $this->maxLength;
    }

    public function message()
    {
        return ':attributeは' . $this->maxLength . '文字以内で入力してください。';
    }
}
