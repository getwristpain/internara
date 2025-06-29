<?php

use App\Helpers\LogicResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;

describe('LogicResponse', function () {

    test('creates a successful response', function () {
        $response = LogicResponse::make(true, 'Data saved successfully');

        expect($response->passes())->toBeTrue()
            ->and($response->getMessage())->toBe('Data saved successfully')
            ->and($response->getStatus())->toBe('success')
            ->and($response->getCode())->toBe(200);
    });

    test('creates a failure response', function () {
        $response = LogicResponse::make(false, 'Failed to save data');

        expect($response->fails())->toBeTrue()
            ->and($response->getMessage())->toBe('Failed to save data')
            ->and($response->getStatus())->toBe('error')
            ->and($response->getCode())->toBe(500)
            ->and($response->hasErrors())->toBeTrue();
    });

    test('sets and retrieves the payload', function () {
        $payload = ['name' => 'John Doe'];
        $response = LogicResponse::make()->withPayload($payload);

        expect($response->payload())->toBeInstanceOf(Collection::class)
            ->and($response->payload()->get('name'))->toBe('John Doe');
    });

    test('adds and retrieves errors', function () {
        $response = LogicResponse::make(false)->addErrors('email', 'Invalid email address');

        expect($response->fails())->toBeTrue()
            ->and($response->getErrors())->toBeInstanceOf(MessageBag::class)
            ->and($response->getErrors('email'))->toContain('Invalid email address');
    });

    test('clears all errors correctly', function () {
        $response = LogicResponse::make(false)
            ->addErrors('username', 'Username is required')
            ->clearErrors();

        expect($response->getErrors())->toBeNull();
    });

    test('returns operator on success', function () {
        $operator = new stdClass();
        $response = LogicResponse::make()->operator($operator);

        expect($response->then())->toBeInstanceOf(stdClass::class);
    });

    test('returns self on failure', function () {
        $response = LogicResponse::make(false);

        expect($response->then())->toBeInstanceOf(LogicResponse::class);
    });

    test('converts to array correctly', function () {
        $response = LogicResponse::make(true, 'Operation completed')->toArray();

        expect($response)->toHaveKey('success')
            ->and($response)->toHaveKey('message')
            ->and($response['success'])->toBeTrue()
            ->and($response['message'])->toBe('Operation completed');
    });

    test('detects empty payload correctly', function () {
        $response = LogicResponse::make()->withPayload([]);

        expect($response->isEmpty())->toBeTrue();
    });
});
