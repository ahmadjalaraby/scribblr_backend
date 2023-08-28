<?php

namespace App\Enums\User;

use Webfox\LaravelBackedEnums\BackedEnum;
use Webfox\LaravelBackedEnums\IsBackedEnum;

enum UserGender: string implements BackedEnum
{
    use IsBackedEnum;

    case male = 'm';

    case female = 'f';

    case other = 'o';
}
