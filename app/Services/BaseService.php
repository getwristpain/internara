<?php

namespace App\Services;

use App\Helpers\LogicResponse;

class BaseService
{
    public function response(string $type = '', string $message = ''): LogicResponse
    {
        if (!empty($type)) {
            $type = in_array($type, ['success', 'error']) ? $type : null;
            return LogicResponse::make($type && $type === 'success', $message)
                ->withType($this)
                ->withPayload($this->toArray());
        }

        return LogicResponse::make()
            ->withType($this)
            ->withPayload($this->toArray());
    }

    public function toArray(): array
    {
        return [];
    }
}
