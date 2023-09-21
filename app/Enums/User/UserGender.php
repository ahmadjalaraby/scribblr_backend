<?php

namespace App\Enums\User;


use App\Traits\IsEnumValues;

enum UserGender: string
{
    use IsEnumValues;

    case male = 'm';

    case female = 'f';

    case other = 'o';
}
