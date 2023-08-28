<?php

namespace App\ViewModels;

use App\Constants\Pagination\PaginationConstants;
use App\ValueObjects\PaginateOptions;
use Illuminate\Contracts\Support\Arrayable;
use Reflection;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Support\Str;

abstract class ViewModel implements Arrayable
{
    /** @var PaginateOptions|null This variable will pass the options of pagination */
    protected ?PaginateOptions $paginateOptions;

    public function __construct(?PaginateOptions $paginateOptions = new PaginateOptions(true, PaginationConstants::DEFAULT_PER_PAGE))
    {
        $this->paginateOptions = $paginateOptions;
    }

    public function toArray(): array
    {
        return collect((new ReflectionClass($this))->getMethods())
            ->reject(fn (ReflectionMethod $method) =>
            in_array($method->getName(), ['__construct', '__invoke', 'toArray'])
            )
            ->filter(fn (ReflectionMethod $method) =>
            in_array('public', Reflection::getModifierNames($method->getModifiers()))
            )
            ->mapWithKeys(fn (ReflectionMethod $method) => [
                Str::snake($method->getName()) => $this->{$method->getName()}()
            ])
            ->toArray();
    }
}
