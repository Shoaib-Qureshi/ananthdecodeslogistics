<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TikTokUrl implements Rule
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
        // Regular expression to match TikTok URLs in the format `https://www.tiktok.com/@username/video/video_id`
        if (preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?tiktok\.com\/@[\w.-]+\/video\/\d+$/", $value)) {
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
        return 'You have entered an invalid TikTok URL.';
    }
}