<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IntegerFromMinToMaxRule implements ValidationRule
{
    public function __construct(
        protected int $min,
        protected int $max,
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
            'integer',
            'min:' . $this->min,
            'max:' . $this->max,
        ];
    }
}
