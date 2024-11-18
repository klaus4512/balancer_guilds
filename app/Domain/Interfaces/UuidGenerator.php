<?php

namespace App\Domain\Interfaces;

interface UuidGenerator
{
    public function generate():string;
}
