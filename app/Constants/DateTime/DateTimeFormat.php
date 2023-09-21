<?php

namespace App\Constants\DateTime;

final class DateTimeFormat
{
    /** @var string This variable for the user date of birth format */
    public const DATE_OF_BIRTH = 'Y-m-d';

    /** @var string This variable for the datetime style of article publish_at */
    public const PUBLISH_AT = 'Y-m-d H:i';

    /** @var string This const for default datetime format which will be on this format [`Y-m-d H:i:s`] */
    public const DEFAULT = 'Y-m-d h:i:s';
}
