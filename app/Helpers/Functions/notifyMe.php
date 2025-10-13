<?php

use App\Helpers\NotifyMe;

if (!function_exists('notifyMe')) {
    function notifyMe(?string $message = null, ?string $type = null): NotifyMe
    {
        $notifyMe = new NotifyMe();

        if (empty($message)) {
            return $notifyMe;
        }

        return $notifyMe->make($message, $type);
    }
}
