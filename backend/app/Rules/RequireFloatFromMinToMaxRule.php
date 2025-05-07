<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RequireFloatFromMinToMaxRule implements ValidationRule
{
    public function __construct(
        protected float $min,
        protected float $max,
        protected int $precision = 6
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
        return [
            'required',
            'numeric',
            'regex:/^-?\d+(\.\d{1,' . $this->precision . '})?$/',
            'min:' . $this->min,
            'max:' . $this->max,
        ];
    }
}
