<?php

use App\Models\User;
use App\Services\OwnerService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


it('returns null if no owner exists', function () {
    User::truncate();
    $service = new OwnerService();

    expect($service->get())->toBeNull();
});

it('returns the owner user if exists', function () {
    User::truncate();
    $owner = User::create([
        'name' => 'Owner Test',
        'email' => 'owner@example.com',
        'username' => 'ownertest',
        'password' => bcrypt('password'),
        'type' => 'owner',
    ]);

    $service = new OwnerService();

    expect($service->get())->not()->toBeNull()
        ->and($service->get()->id)->toBe($owner->id)
        ->and($service->get()->type)->toBe('owner');
});
