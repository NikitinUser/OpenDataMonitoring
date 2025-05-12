<?php

namespace App\Rules;

use App\Rules\BaseRule;

class StringEnglishLength extends BaseRule
{
    public function __construct(
        protected int $minLength,
        protected int $maxLength,
        protected bool $required = false,
    ) {
    }

    public function rules(): array
    {
        $rules = [
            'string',
            'regex:/^[a-zA-Z ]+$/',
            'min:' . $this->minLength,
            'max:' . $this->maxLength,
        ];

        return $this->requred($rules, $this->required);
    }
}
