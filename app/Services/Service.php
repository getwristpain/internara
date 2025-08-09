<?php

namespace App\Services;

use App\Helpers\LogicResponse;

class Service
{
    public function response(): LogicResponse
    {
        return LogicResponse::make()
            ->withType($this)
            ->withPayload($this->toArray());
    }

    public function toArray(): array
    {
        return [];
    }
}
