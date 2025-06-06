<?php

namespace App\Contracts;

use App\Helpers\LogicResponse;

interface LogicResponseContract
{
    public static function response(bool $success, string $message = '', string $status = '', int $code = 0, string $type = '', array $payload = []): LogicResponse;

    public function success(string $message = ''): LogicResponse;

    public function failure(string $message = ''): LogicResponse;
}
