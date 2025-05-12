<?php

namespace App\Rules;

use App\Rules\BaseRule;
use Illuminate\Validation\Rule;

class RequireIntegerExistsPrimaryKeyRule extends BaseRule
{
    public function __construct(
        protected string $table,
        protected string $primaryFieldType = 'integer',
        protected string $primaryField = 'id',
        protected bool $required = true,
    ) {
    }

    public function rules(): array
    {
        $rules = [
            $this->primaryFieldType,
            Rule::exists($this->table, $this->primaryField),
        ];

        return $this->requred($rules, $this->required);
    }
}
