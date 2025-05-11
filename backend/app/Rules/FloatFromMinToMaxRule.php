<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FloatFromMinToMaxRule implements ValidationRule
{
    public function __construct(
        protected float $min,
        protected float $max,
        protected int $precision = 6,
        protected bool $required = false,
    ) {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
    }

    public function rules(): array
    {
        $rules = [
            'numeric',
            'regex:/^-?\d+(\.\d{1,' . $this->precision . '})?$/',
            'min:' . $this->min,
            'max:' . $this->max,
        ];

        if ($this->required) {
            $rules[] = 'required';
        }

        return $rules;
    }
}
