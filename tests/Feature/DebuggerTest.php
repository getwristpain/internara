<?php

use App\Debugger;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;

beforeEach(function () {
    $this->debugger = new class {
        use Debugger;
    };
});

it('initializes with an empty MessageBag', function () {
    expect($this->debugger->getErrors())
        ->toBeInstanceOf(MessageBag::class)
        ->and($this->debugger->getErrors()->isEmpty())
        ->toBeTrue();
});

it('adds and retrieves errors correctly', function () {
    $this->debugger->addError('Test error message');

    expect($this->debugger->getErrors()->first())
        ->toBe('Test error message');
});

it('logs debug messages correctly and returns the message', function () {
    Log::shouldReceive('log')
        ->once()
        ->withArgs(
            fn($level, $message, $context) =>
            $level === 'debug' &&
                $message === 'Test debug message' &&
                is_array($context)
        );

    expect($this->debugger->debug('debug', 'Test debug message'))
        ->toBe('Test debug message');
});

it('sanitizes levels correctly using the helper', function () {
    expect(Helper::sanitize('error', ['debug', 'error']))
        ->toBe('error')
        ->and(Helper::sanitize('invalid_level', ['debug', 'error']))
        ->toBeNull();
});

it('stringifies values correctly using the helper', function () {
    expect(Helper::stringify(null))
        ->toBe('null')
        ->and(Helper::stringify(['key' => 'value']))
        ->toBe(json_encode(['key' => 'value'], JSON_PRETTY_PRINT));
});
