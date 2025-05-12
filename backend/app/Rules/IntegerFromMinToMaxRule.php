<?php

namespace App\Rules;

use App\Rules\BaseRule;

class IntegerFromMinToMaxRule extends BaseRule
{
    public function __construct(
        protected int $min,
        protected int $max,
        protected bool $required = false,
    ) {
    }

    public function rules(): array
    {
        $rules = [
            'integer',
            'min:' . $this->min,
            'max:' . $this->max,
        ];

        return $this->requred($rules, $this->required);
    }
}
