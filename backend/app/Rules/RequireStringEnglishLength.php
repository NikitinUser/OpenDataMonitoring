<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RequireStringEnglishLength implements ValidationRule
{
    public function __construct(
        protected int $minLength,
        protected int $maxLength,
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
            'string',
            'regex:/^[a-zA-Z ]+$/',
            'min:' . $this->minLength,
            'max:' . $this->maxLength,
        ];
    }
}
