<?php

namespace App\Helper;

use Illuminate\Support\Str;

class CodeHelper
{

    public function generate_random_code($length = 2)
    {
        $letters = Str::upper(Str::random($length));
        $numbers = rand(100, 999);
        return $letters . $numbers;
    }

    public function generate_random_codes_array($count = 10)
    {
        $codes = [];
        for ($i = 0; $i < $count; $i++) {
            $codes[] = self::generate_random_code();
        }
        return $codes;
    }

    public function randomCode($count = 10)
    {
        $codesArray = self::generate_random_codes_array($count);
        return implode(',', $codesArray);
    }
}
