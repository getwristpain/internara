<?php

use App\Helpers\ModelWrapper;
use App\Helpers\LogicResponse;
use App\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->school = School::factory()->create();
    $this->wrapper = ModelWrapper::make($this->school);
});

describe('ModelWrapper', function () {
    test('can get all records', function () {
        $result = $this->wrapper->all();
        expect($result)->toBeInstanceOf(Collection::class);
    });

    test('can get records with where', function () {
        $result = $this->wrapper->get(['id' => $this->school->id]);
        expect($result)->toBeInstanceOf(Collection::class);
    });

    test('can find a record', function () {
        $result = $this->wrapper->find($this->school->id);
        expect($result)->toBeInstanceOf(Model::class)
            ->and($result->id)->toBe($this->school->id);
    });

    test('returns null when find not found', function () {
        $result = $this->wrapper->find(999999);
        expect($result)->toBeNull();
    });

    test('can get first record', function () {
        $result = $this->wrapper->first(['id' => $this->school->id]);
        expect($result)->toBeInstanceOf(Model::class);
    });

    test('can get firstOrFail record', function () {
        $result = $this->wrapper->firstOrFail(['id' => $this->school->id]);
        expect($result)->toBeInstanceOf(Model::class);
    });

    test('throws on firstOrFail if not found', function () {
        expect(fn () => $this->wrapper->firstOrFail(['id' => 999999]))->toThrow(Exception::class);
    });

    test('can firstOrCreate', function () {
        $result = $this->wrapper->firstOrCreate(['name' => 'Unique School'], ['address' => 'Jl. Baru']);
        expect($result)->toBeInstanceOf(Model::class);
    });

    test('can create a record', function () {
        $response = $this->wrapper->create(['name' => 'Created School', 'address' => 'Jl. Baru']);
        expect($response)->toBeInstanceOf(LogicResponse::class)
            ->and($response->passes())->toBeTrue();
    });

    test('can insert multiple records', function () {
        $rows = [
            ['name' => 'Bulk1', 'address' => 'Jl. Bulk1'],
            ['name' => 'Bulk2', 'address' => 'Jl. Bulk2'],
        ];
        $response = $this->wrapper->insert($rows);
        expect($response)->toBeInstanceOf(LogicResponse::class)
            ->and($response->passes())->toBeTrue();
    });

    test('can update records', function () {
        $response = $this->wrapper->update(['name' => 'Updated'], ['id' => $this->school->id]);
        expect($response)->toBeInstanceOf(LogicResponse::class)
            ->and($response->passes())->toBeTrue();
    });

    test('can updateOrCreate records', function () {
        $response = $this->wrapper->updateOrCreate(['name' => 'Upserted School'], ['address' => 'Jl. Upsert']);
        expect($response)->toBeInstanceOf(LogicResponse::class)
            ->and($response->passes())->toBeTrue();
    });

    test('can delete a record', function () {
        $response = $this->wrapper->delete($this->school->id);
        expect($response)->toBeInstanceOf(LogicResponse::class)
            ->and($response->passes())->toBeTrue();
    });

    test('can destroy multiple records', function () {
        $school1 = School::create(['name' => 'A', 'address' => 'Jl. A']);
        $school2 = School::create(['name' => 'B', 'address' => 'Jl. B']);
        $ids = [$school1->id, $school2->id];
        $response = $this->wrapper->destroy($ids);
        expect($response)->toBeInstanceOf(LogicResponse::class)
            ->and($response->passes())->toBeTrue();
    });

    test('can convert to array', function () {
        $result = $this->wrapper->toArray();
        expect($result)->toBeArray();
    });

    test('can convert to attributes', function () {
        $result = $this->wrapper->toAttributes();
        expect($result)->not->toBeNull();
    });

    test('can convert to collection', function () {
        $result = $this->wrapper->toCollection();
        expect($result)->toBeInstanceOf(Collection::class);
    });

    test('can return response', function () {
        $result = $this->wrapper->response();
        expect($result)->toBeInstanceOf(LogicResponse::class);
    });

    test('handles null model gracefully', function () {
        $wrapper = ModelWrapper::make(null);
        expect($wrapper->all())->toBeNull()
            ->and($wrapper->get())->toBeNull()
            ->and($wrapper->find(1))->toBeNull()
            ->and($wrapper->first())->toBeNull()
            ->and($wrapper->firstOrCreate(['id' => 1], []))->toBeNull()
            ->and($wrapper->create(['name' => 'test']))->toBeInstanceOf(LogicResponse::class)
            ->and($wrapper->insert([]))->toBeInstanceOf(LogicResponse::class)
            ->and($wrapper->update(['name' => 'test']))->toBeInstanceOf(LogicResponse::class)
            ->and($wrapper->updateOrCreate(['id' => 1], ['name' => 'test']))->toBeInstanceOf(LogicResponse::class)
            ->and($wrapper->delete(1))->toBeInstanceOf(LogicResponse::class)
            ->and($wrapper->destroy([1, 2]))->toBeInstanceOf(LogicResponse::class)
            ->and($wrapper->toArray())->toBeArray()
            ->and($wrapper->toCollection())->toBeInstanceOf(Collection::class)
            ->and($wrapper->response())->toBeInstanceOf(LogicResponse::class);
    });
});
