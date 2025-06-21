<?php

namespace Tests\Dummies;

use App\Helpers\Helper;

/**
 * Class Dummy
 *
 * A simple dummy class for testing purposes.
 *
 * @package Tests\Dummies
 */
class Dummy
{
    /**
     * @var array<string, mixed> Properties of the dummy object
     */
    public array $properties = [
        'name' => 'Testing',
        'type' => 'test',
        'message' => 'testing is everything',
    ];

    /**
     * Dummy constructor.
     *
     * @param array<string, mixed> $properties Optional properties to override defaults
     */
    public function __construct(array $properties = [])
    {
        $this->properties = $properties;
    }

    /**
     * Magic getter to access properties.
     *
     * @param string $key Property key
     * @return mixed|null
     */
    public function __get(string $key)
    {
        return Helper::getArray($this->properties, $key);
    }

    /**
     * Magic setter to set properties.
     *
     * @param string $key Property key
     * @param mixed $value Property value
     * @return void
     */
    public function __set(string $key, $value): void
    {
        Helper::setArray($this->properties, $key, $value);
    }

    /**
     * Returns a greeting message.
     *
     * @return string
     */
    public function greet(): string
    {
        return 'Hi ' . ($this->properties['name'] ?? 'there') . '!';
    }

    /**
     * Returns a secret message.
     *
     * @return string
     */
    protected function secret(): string
    {
        return 'This is secret.';
    }
}
