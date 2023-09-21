<?php

declare(strict_types=1);

namespace App\Traits;

/**
 * @method static cases()
 */
trait IsEnumValues
{
    /**
     * Get array of values of this enum
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(array: static::cases(), column_key: 'value');
    }
}
