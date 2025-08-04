<?php

namespace App\Services;

use App\Helpers\LogicResponse;

class Service
{
    public function response(): LogicResponse
    {
        return LogicResponse::make()
            ->with('type', $this)
            ->with('payload', $this->toArray());
    }

    public function toArray(): array
    {
        return [];
    }
}
