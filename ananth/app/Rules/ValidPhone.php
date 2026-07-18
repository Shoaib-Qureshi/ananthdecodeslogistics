<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidPhone implements Rule
{
    private $countryCode;
    private $message = 'Please enter a valid phone number.';

    public function __construct($countryCode = null)
    {
        $this->countryCode = $countryCode;
    }

    public function passes($attribute, $value)
    {
        $value = (string) $value;
        if (!preg_match('/^[0-9\s()+\-]+$/', $value)) {
            return false;
        }

        $digits = strlen(preg_replace('/\D/', '', $value));

        if ($this->countryCode === '+91') {
            $this->message = 'Indian mobile numbers must be exactly 10 digits.';
            return $digits === 10;
        }

        $this->message = 'Please enter a valid phone number (6-15 digits).';
        return $digits >= 6 && $digits <= 15;
    }

    public function message()
    {
        return $this->message;
    }
}
