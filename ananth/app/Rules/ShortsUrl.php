<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ShortsUrl implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtube\.com\/shorts\/)([^\?&\"'>]{11})/", $value, $matches)) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You have entered an invalid YouTube Shorts URL.';
    }
}