<?php

namespace App\Rules;

use App\Http\Services\CompanyService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Cache;

class Symbol implements ValidationRule
{
    private CompanyService $companyService;

    public function __construct()
    {
        $this->companyService = new CompanyService;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $symbolList = array_keys($this->companyService->getCompanySymbolList());
            in_array($value, $symbolList) || $fail('Symbol is invalid');
        } catch (\Exception $e) {
            $fail($e?->getMessage());
        }
    }
}
