<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class AppException extends Exception
{
    /**
     * The user-friendly message to be displayed in the UI.
     *
     * @var string
     */
    protected string $userMessage;

    /**
     * Constructs the exception.
     *
     * @param string $userMessage The message safe to show to the user (e.g., "The resource is not available.").
     * @param string $logMessage The detailed message for the logs (technical).
     * @param int $code The exception code (e.g., HTTP status code).
     * @param \Throwable|null $previous
     */
    public function __construct(
        string $userMessage = 'An application error occurred.',
        string $logMessage = '',
        int $code = 422,
        ?Throwable $previous = null
    ) {
        $this->userMessage = $userMessage;

        // The base exception message carries the technical log message
        parent::__construct($logMessage ?: $userMessage, $code, $previous);
    }

    /**
     * Get the user-friendly message.
     *
     * @return string
     */
    public function getUserMessage(): string
    {
        return $this->userMessage;
    }
}
