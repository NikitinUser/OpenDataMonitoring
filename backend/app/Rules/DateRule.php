<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DateRule implements ValidationRule
{
    public function __construct(
        protected string $format = 'Y-m-d',
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
            'date_format:' . $this->format,
        ];

        if ($this->required) {
            $rules[] = 'required';
        }

        return $rules;
    }
}
