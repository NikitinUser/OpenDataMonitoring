<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StringEnglishLength implements ValidationRule
{
    public function __construct(
        protected int $minLength,
        protected int $maxLength,
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
            'string',
            'regex:/^[a-zA-Z ]+$/',
            'min:' . $this->minLength,
            'max:' . $this->maxLength,
        ];

        if ($this->required) {
            $rules[] = 'required';
        }

        return $rules;
    }
}
