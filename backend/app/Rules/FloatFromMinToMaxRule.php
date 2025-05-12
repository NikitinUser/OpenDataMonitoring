<?php

namespace App\Rules;

use App\Rules\BaseRule;

class FloatFromMinToMaxRule extends BaseRule
{
    public function __construct(
        protected float $min,
        protected float $max,
        protected int $precision = 6,
        protected bool $required = false,
    ) {
    }

    public function rules(): array
    {
        $rules = [
            'numeric',
            'regex:/^-?\d+(\.\d{1,' . $this->precision . '})?$/',
            'min:' . $this->min,
            'max:' . $this->max,
        ];

        return $this->requred($rules, $this->required);
    }
}
