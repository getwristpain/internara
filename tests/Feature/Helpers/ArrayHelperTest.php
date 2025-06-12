<?php

use App\Helpers\ArrayHelper;
use App\Helpers\Debugger;

it('returns true for flat associative array', function () {
    $assoc = ['foo' => 'bar', 'caz' => 123];
    expect(ArrayHelper::isFlatAssoc($assoc))->toBeTrue();
});

it('returns false for array with numeric key', function () {
    $array = ['foo' => 'bar', 1 => 'caz'];
    expect(ArrayHelper::isFlatAssoc($array))->toBeFalse();
});

it('returns true for empty array', function () {
    expect(ArrayHelper::isFlatAssoc([]))->toBeTrue();
});

it('can get a value by string key', function () {
    $arr = ['foo' => 'bar'];
    expect(ArrayHelper::get($arr, 'foo'))->toBe('bar');
});

it('returns default if key does not exist', function () {
    $arr = ['foo' => 'bar'];
    expect(ArrayHelper::get($arr, 'caz', 'default'))->toBe('default');
});

it('can get a value by nested array key', function () {
    $arr = ['a' => ['b' => ['c' => 123]]];
    expect(ArrayHelper::get($arr, ['a', 'b', 'c']))->toBe(123);
});

it('returns default if nested key does not exist', function () {
    $arr = ['a' => ['b' => ['c' => 123]]];
    expect(ArrayHelper::get($arr, ['a', 'x', 'y'], 'not found'))->toBe('not found');
});

it('can set a value by string key', function () {
    $arr = [];
    ArrayHelper::set($arr, 'foo', 'bar');
    expect($arr['foo'])->toBe('bar');
});

it('can set a value by nested array key', function () {
    $arr = [];
    ArrayHelper::set($arr, ['a', 'b', 'c'], 456);
    expect($arr['a']['b']['c'])->toBe(456);
});

it('overwrites existing value when setting', function () {
    $arr = ['foo' => 'bar'];
    ArrayHelper::set($arr, 'foo', 'caz');
    expect($arr['foo'])->toBe('caz');
});
