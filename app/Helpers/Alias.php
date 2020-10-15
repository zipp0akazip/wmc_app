<?php

namespace App\Helpers;

class Alias
{
    public static function make(string $string): string
    {
        return strtolower($string);
    }
}
