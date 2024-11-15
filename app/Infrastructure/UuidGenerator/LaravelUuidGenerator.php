<?php

namespace App\Infrastructure\UuidGenerator;

use App\Domain\Interfaces\UuidGenerator;
use Illuminate\Support\Str;

class LaravelUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return Str::uuid();
    }
}
