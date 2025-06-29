<?php

use App\Helpers\Attribute;

describe('Attribute', function () {
    test('can create and fill attributes', function () {
        $attr = Attribute::make(['foo' => 'bar']);
        expect($attr->get('foo'))->toBe('bar');
        expect($attr->toArray())->toBe(['foo' => 'bar']);
    });

    test('make creates new instance', function () {
        $attr = Attribute::make(['a' => 1]);
        expect($attr)->toBeInstanceOf(Attribute::class);
        expect($attr->get('a'))->toBe(1);
    });

    test('fill replaces attributes', function () {
        $attr = Attribute::make(['a' => 1]);
        $attr->fill(['b' => 2]);
        expect($attr->get('a'))->toBeNull();
        expect($attr->get('b'))->toBe(2);
    });

    test('get returns default if not found', function () {
        $attr = Attribute::make(['x' => 10]);
        expect($attr->get('y', 'default'))->toBe('default');
    });

    test('set assigns value by key', function () {
        $attr = Attribute::make();
        $attr->set('foo', 'bar');
        expect($attr->get('foo'))->toBe('bar');
    });

    test('has checks key existence', function () {
        $attr = Attribute::make(['foo' => 'bar']);
        expect($attr->has('foo'))->toBeTrue();
        expect($attr->has('baz'))->toBeFalse();
    });

    test('only returns only specified keys', function () {
        $attr = Attribute::make(['a' => 1, 'b' => 2]);
        $only = $attr->only(['a']);
        expect($only->toArray())->toBe(['a' => 1]);
    });

    test('except returns all except specified keys', function () {
        $attr = Attribute::make(['a' => 1, 'b' => 2]);
        $except = $attr->except(['b']);
        expect($except->toArray())->toBe(['a' => 1]);
    });

    test('merge combines attributes', function () {
        $attr = Attribute::make(['a' => 1]);
        $merged = $attr->merge(['b' => 2]);
        expect($merged->toArray())->toBe(['a' => 1, 'b' => 2]);
    });

    test('map applies callback to all attributes', function () {
        $attr = Attribute::make(['a' => 1, 'b' => 2]);
        $mapped = $attr->map(fn ($v) => $v * 2);
        expect($mapped->toArray())->toBe(['a' => 2, 'b' => 4]);
    });

    test('isEmpty returns true if no attributes', function () {
        $attr = Attribute::make();
        expect($attr->isEmpty())->toBeTrue();
        $attr->set('foo', 'bar');
        expect($attr->isEmpty())->toBeFalse();
    });

    test('toCollection returns a collection', function () {
        $attr = Attribute::make(['a' => 1]);
        $collection = $attr->toCollection();
        expect($collection)->toBeInstanceOf(\Illuminate\Support\Collection::class);
        expect($collection->get('a'))->toBe(1);
    });

    test('magic getter, setter, and isset work', function () {
        $attr = Attribute::make();
        $attr->foo = 'bar';
        expect($attr->foo)->toBe('bar');
        expect(isset($attr->foo))->toBeTrue();
        expect(isset($attr->baz))->toBeFalse();
    });
});
