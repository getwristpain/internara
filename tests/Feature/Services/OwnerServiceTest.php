<?php

use App\Models\User;
use App\Services\OwnerService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('OwnerService', function () {
    test('returns null if no owner exists', function () {
        User::truncate();
        $service = new OwnerService();

        expect($service->model()->instance())->toBeNull();
    });

    test('returns the owner user if exists', function () {
        User::truncate();
        $owner = User::factory()->create([
            'type' => 'owner',
        ]);

        $service = new OwnerService();

        expect($service->model()->instance())->not()->toBeNull()
            ->and($service->model()->instance()->id)->toBe($owner->id)
            ->and($service->model()->instance()->type)->toBe('owner');
    });
});
