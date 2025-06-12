<?php

use App\Helpers\LogicResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Dummies\DummyService;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->dummyService = new DummyService();
});

it('can be validate correctly', function () {
    $data = [
        'name' => 'test',
        'username' => 'user123',
        'password' => '123'
    ];

    $rules = [
        'name' => 'string',
        'username' => 'string',
        'password' => 'string'
    ];

    $advanceRules = [
        'name' => 'string|min:5',
        'username' => 'string|min:5',
        'password' => 'string|min:5'
    ];

    $valid = $this->dummyService->validate($data, $rules);
    $invalid = $this->dummyService->validate($data, $advanceRules);

    expect(is_a($valid, LogicResponse::class))->toBeTrue()
        ->and(is_a($invalid, LogicResponse::class))->toBeTrue()
        ->and($valid->passes())->toBeTrue()
        ->and($invalid->passes())->toBeFalse();
});
