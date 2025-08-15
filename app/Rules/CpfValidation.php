<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValidCpf($value)) {
            $fail('O :attribute deve ser um CPF válido.');
        }
    }

    /**
     * Validate CPF format and check digit
     */
    private function isValidCpf(string $cpf): bool
    {
        // Remove non-numeric characters
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Check if CPF has 11 digits
        if (strlen($cpf) !== 11) {
            return false;
        }

        // Check for known invalid CPFs (all same digits)
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        // Calculate first check digit
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += intval($cpf[$i]) * (10 - $i);
        }
        $remainder = $sum % 11;
        $digit1 = $remainder < 2 ? 0 : 11 - $remainder;

        // Check first digit
        if (intval($cpf[9]) !== $digit1) {
            return false;
        }

        // Calculate second check digit
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += intval($cpf[$i]) * (11 - $i);
        }
        $remainder = $sum % 11;
        $digit2 = $remainder < 2 ? 0 : 11 - $remainder;

        // Check second digit
        return intval($cpf[10]) === $digit2;
    }
}