<?php

namespace App\Mixins;

use Closure;

final class StrMixin
{
    /**
     * This function will return a closure for addSlash to string variable types
     * @return Closure
     */
    public function addSlash(): Closure
    {
        return function ($str, bool $inFirst = false) {
            return $inFirst ? "/$str" : "$str/";
        };
    }
}
