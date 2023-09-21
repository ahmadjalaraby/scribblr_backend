<?php

namespace App\Traits;

trait HasSerializeDate
{
    /**
     * Serialize date to a format
     * @param $date
     * @return string
     */
    protected function serializeDate($date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
