<?php

namespace App\Rules;

use App\Rules\BaseRule;

class DateTimeRule extends BaseRule
{
    public function __construct(
        protected string $format = 'Y-m-d H:i:s',
        protected bool $required = false,
    ) {
    }

    public function rules(): array
    {
        $rules = [
            'date_format:' . $this->format,
        ];

        return $this->requred($rules, $this->required);
    }
}
