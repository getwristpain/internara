<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class NotifyMe
{
    public const SUCCESS = 'success';
    public const INFO    = 'info';
    public const WARNING = 'warning';
    public const ERROR   = 'error';

    /**
     * The main static method to trigger a flash notification/event.
     *
     * @param string $message The notification message content.
     * @param string $type The type of notification (success, info, warning, error).
     * @return static
     */
    public static function make(string $message, string $type = self::INFO): static
    {
        self::pushNotification($message, $type);

        return new static();
    }

    /**
     * Determines the context (Livewire or standard HTTP) and pushes the notification.
     *
     * @param string $message The notification message.
     * @param string $type The notification type.
     * @return void
     */
    protected static function pushNotification(string $message, string $type): void
    {
        $payload = [
            'message' => $message,
            'type' => $type,
        ];

        event('notify-me', $payload);
        self::pushToSession($payload);
    }

    /**
     * Appends a new notification object to the 'notify-me' session flash array.
     *
     * @param array $payload The notification data (message and type).
     * @return void
     */
    protected static function pushToSession(array $payload): void
    {
        $notifications = Session::get('notify-me', collect([]));

        if (!($notifications instanceof Collection)) {
            $notifications = collect($notifications);
        }

        $isDuplicate = $notifications->contains(function ($notification) use ($payload) {
            return $notification['message'] === $payload['message']
                    && $notification['type'] === $payload['type'];
        });

        if (!$isDuplicate) {
            $notifications->push($payload);
        }

        Session::flash('notify-me', $notifications);
    }

    /**
     * Creates a 'success' type notification.
     *
     * @param string $message The notification message.
     * @return static
     */
    public static function success(string $message): static
    {
        self::make($message, self::SUCCESS);
        return new static();
    }

    /**
     * Creates an 'info' type notification.
     *
     * @param string $message The notification message.
     * @return static
     */
    public static function info(string $message): static
    {
        self::make($message, self::INFO);
        return new static();
    }

    /**
     * Creates a 'warning' type notification.
     *
     * @param string $message The notification message.
     * @return static
     */
    public static function warning(string $message): static
    {
        self::make($message, self::WARNING);
        return new static();
    }

    /**
     * Creates an 'error' type notification.
     *
     * @param string $message The notification message.
     * @return static
     */
    public static function error(string $message): static
    {
        self::make($message, self::ERROR);
        return new static();
    }
}
