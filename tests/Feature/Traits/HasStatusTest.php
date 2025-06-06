<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\HasStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {

    Schema::create('dummies', function (Blueprint $table) {
        $table->id();
        $table->string('name')->nullable();
        $table->timestamps();
    });

    if (!Schema::hasTable('statusables')) {
        Schema::create('statusables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('status_id');
            $table->morphs('statusable');
            $table->timestamps();
        });
    }

    if (!Schema::hasTable('statuses')) {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->boolean('flag')->default(false);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }
});

afterEach(function () {
    Schema::dropIfExists('dummies');
    Schema::dropIfExists('statusables');
    Schema::dropIfExists('statuses');
});

class DummyModel extends Model
{
    use HasStatus;

    protected $table = 'dummies';
    protected $guarded = [];
    public $timestamps = true;

    public array $initialStatuses = [
        'type1' => [
            ['name' => 'statusA'],
            ['name' => 'statusB'],
        ],
    ];
}

it('attaches initial statuses on create', function () {
    $dummy = DummyModel::create(['name' => 'test']);
    $statuses = $dummy->getStatuses('type1');
    expect($statuses)->toHaveCount(2);
    expect($statuses->pluck('name'))->toContain('statusA', 'statusB');
    expect($statuses->pluck('type')->unique())->toContain('type1');
});

it('can get and update status', function () {
    $dummy = DummyModel::create(['name' => 'test']);
    $status = $dummy->firstStatus('statusA', 'type1');
    expect($status)->not()->toBeNull();

    $updated = $dummy->updateStatus(['name' => 'statusA', 'type' => 'type1'], ['flag' => true]);
    expect($updated)->toBeTrue();
    $status->refresh();
    expect($status->flag)->toBeTrue();
});

it('can mark and switch status', function () {
    $dummy = DummyModel::create(['name' => 'test']);
    $dummy->markStatus('statusA', 'type1', 'flag', true);
    $statusA = $dummy->firstStatus('statusA', 'type1');
    expect($statusA->flag)->toBeTrue();

    $dummy->switchStatus('statusB', 'type1', 'flag');
    $statusA->refresh();
    $statusB = $dummy->firstStatus('statusB', 'type1');
    expect($statusA->flag)->toBeFalse();
    expect($statusB->flag)->toBeTrue();
});

it('can set default status', function () {
    $dummy = DummyModel::create(['name' => 'test']);
    $dummy->setDefaultStatus('statusB', 'type1');
    $statusA = $dummy->firstStatus('statusA', 'type1');
    $statusB = $dummy->firstStatus('statusB', 'type1');
    expect($statusA->is_default)->toBeFalse();
    expect($statusB->is_default)->toBeTrue();
});
