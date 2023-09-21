<?php

namespace App\JsonApi\Shared\Enums;

enum ModelState: string
{
    /** @var string Indicates that the model has been created */
    const CREATED = 'created';
    /** @var string Indicates that the model is being creating */
    const CREATING = 'creating';
    /** @var string Indicates that the model has been updated */
    const UPDATED = 'updated';
    /** @var string Indicates that the model is being updating */
    const UPDATING = 'updating';
}
