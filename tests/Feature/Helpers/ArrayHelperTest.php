<?php

use App\Helpers\ArrayHelper;
use App\Helpers\Debugger;

it('returns true for flat associative array', function () {
    $assoc = ['foo' => 'bar', 'baz' => 123];
    expect(ArrayHelper::isFlatAssoc($assoc))->toBeTrue();
});

it('returns false for array with numeric key', function () {
    $array = ['foo' => 'bar', 1 => 'baz'];
    expect(ArrayHelper::isFlatAssoc($array))->toBeFalse();
});

it('returns true for empty array', function () {
    expect(ArrayHelper::isFlatAssoc([]))->toBeTrue();
});
