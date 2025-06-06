<?php

use App\Helpers\Attribute;

it('can be constructed and converted to array', function () {
    $attr = new Attribute(['foo' => 'bar', 'baz' => 123]);
    expect($attr->toArray())->toBe(['foo' => 'bar', 'baz' => 123]);
});

it('make() creates a new instance', function () {
    $attr = Attribute::make(['a' => 1]);
    expect($attr)->toBeInstanceOf(Attribute::class)
        ->and($attr->toArray())->toBe(['a' => 1]);
});

it('fill() replaces attributes and respects defaults', function () {
    $attr = new Attribute(['foo' => 'bar'], ['foo' => 'default', 'baz' => 1]);
    expect($attr->toArray())->toBe(['foo' => 'bar', 'baz' => 1]);
    $attr->fill(['baz' => 2]);
    expect($attr->toArray())->toBe(['baz' => 2]);
});

it('get() returns value or default', function () {
    $attr = new Attribute(['foo' => 'bar']);
    expect($attr->get('foo'))->toBe('bar')
        ->and($attr->get('baz', 'default'))->toBe('default');
});

it('set() sets a value', function () {
    $attr = new Attribute(['foo' => 'bar']);
    $attr->set('baz', 123);
    expect($attr->get('baz'))->toBe(123);
});

it('has() checks for key existence', function () {
    $attr = new Attribute(['foo' => 'bar']);
    expect($attr->has('foo'))->toBeTrue()
        ->and($attr->has('baz'))->toBeFalse();
});

it('only() returns only specified keys', function () {
    $attr = new Attribute(['foo' => 1, 'bar' => 2, 'baz' => 3]);
    $only = $attr->only(['foo', 'baz']);
    expect($only)->toBeInstanceOf(Attribute::class)
        ->and($only->toArray())->toBe(['foo' => 1, 'baz' => 3]);
});

it('except() returns all except specified keys', function () {
    $attr = new Attribute(['foo' => 1, 'bar' => 2, 'baz' => 3]);
    $except = $attr->except(['bar']);
    expect($except)->toBeInstanceOf(Attribute::class)
        ->and($except->toArray())->toBe(['foo' => 1, 'baz' => 3]);
});

it('merge() merges new items', function () {
    $attr = new Attribute(['foo' => 1]);
    $merged = $attr->merge(['bar' => 2]);
    expect($merged)->toBeInstanceOf(Attribute::class)
        ->and($merged->toArray())->toBe(['foo' => 1, 'bar' => 2]);
});

it('map() applies callback to all values', function () {
    $attr = new Attribute(['a' => 1, 'b' => 2]);
    $mapped = $attr->map(fn ($v) => $v * 2);
    expect($mapped->toArray())->toBe(['a' => 2, 'b' => 4]);
});

it('isEmpty() returns true for empty, false otherwise', function () {
    expect((new Attribute([]))->isEmpty())->toBeTrue();
    expect((new Attribute(['x' => 1]))->isEmpty())->toBeFalse();
});

it('toCollection() returns a collection', function () {
    $attr = new Attribute(['foo' => 'bar']);
    $col = $attr->toCollection();
    expect($col)->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->and($col->toArray())->toBe(['foo' => 'bar']);
});

it('magic get/set/isset works', function () {
    $attr = new Attribute(['foo' => 'bar']);
    expect($attr->foo)->toBe('bar');
    $attr->baz = 123;
    expect($attr->baz)->toBe(123);
    expect(isset($attr->foo))->toBeTrue();
    expect(isset($attr->notfound))->toBeFalse();
});
