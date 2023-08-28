<?php

namespace App\DataTransferObjects;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Spatie\LaravelData\Data;

final class CountryData extends Data
{

    public function __construct(
        public readonly ?int   $id,
        public readonly string $name,
        public readonly string $code,
        public readonly string $start,
        public readonly bool   $active,
    )
    {
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->all(),
        ]);
    }

    public static function fromModel(Country $country): self
    {
        return self::from([
            ...$country->toArray(),
        ]);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'start' => $this->start,
            'active' => $this->active,
        ];
    }

    public static function withValidator(Validator $validator): void
    {
        $validator->setRules(self::rules());
    }

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'code' => ['required', 'string'],
            'start' => ['required', 'string'],
        ];
    }
}
