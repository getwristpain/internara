<?php

use App\Helpers\Support;

describe('Support', function () {
    test('stringify returns correct string for various types', function () {
        expect(Support::stringify(['a' => 1]))->toBeJson();
        expect(Support::stringify(true))->toBe('true');
        expect(Support::stringify(false))->toBe('false');
        expect(Support::stringify(123))->toBe('123');
        expect(Support::stringify(12.5))->toBe('12.5');
        expect(Support::stringify('foo'))->toBe('foo');
        expect(Support::stringify(null))->toBe('NULL');
    });

    test('hasNestedArray detects nested arrays', function () {
        expect(Support::hasNestedArray(['a' => [1, 2], 'b' => 2]))->toBeTrue();
        expect(Support::hasNestedArray(['a' => 1, 'b' => 2]))->toBeFalse();
    });

    test('isFlatAssocArray validates associative arrays', function () {
        expect(Support::isFlatAssocArray(['a' => 1, 'b' => 2]))->toBeTrue();
        expect(Support::isFlatAssocArray([1, 2, 3]))->toBeFalse();
    });

    test('getArray retrieves values by key or path', function () {
        $arr = ['a' => ['b' => ['c' => 5]], 'x' => 1];
        expect(Support::getArray($arr, 'x'))->toBe(1);
        expect(Support::getArray($arr, ['a', 'b', 'c']))->toBe(5);
        expect(Support::getArray($arr, 'notfound', 'default'))->toBe('default');
    });

    test('setArray sets values by key or path', function () {
        $arr = [];
        Support::setArray($arr, ['a', 'b', 'c'], 10);
        expect($arr['a']['b']['c'])->toBe(10);

        Support::setArray($arr, 'x', 5);
        expect($arr['x'])->toBe(5);
    });

    test('getKeysWithKeywords returns keys containing keywords', function () {
        $arr = ['apple' => 1, 'banana' => 2, 'apricot' => 3];
        $result = Support::getKeysWithKeywords($arr, ['app']);
        expect($result)->toBe(['apple']);
    });

    test('filter returns not empty by default', function () {
        $arr = ['a' => 1, 'b' => null, 'c' => 0, 'd' => 'foo'];
        $filtered = Support::filter($arr);
        expect($filtered)->toHaveKey('a');
        expect($filtered)->toHaveKey('d');
        expect($filtered)->not->toHaveKey('b');
        expect($filtered)->not->toHaveKey('c');
    });

    test('filter with callable', function () {
        $arr = ['a' => 1, 'b' => 2, 'c' => 3];
        $filtered = Support::filter($arr, fn ($v) => $v > 1);
        expect($filtered)->toBe(['b' => 2, 'c' => 3]);
    });

    test('filter with keywords', function () {
        $arr = ['apple' => 1, 'banana' => 2, 'apricot' => 3];
        $filtered = Support::filter($arr, ['keywords' => ['app']]);
        expect($filtered)->toHaveKey('apple');
        expect($filtered)->not->toHaveKey('banana');
    });

    test('filter with associative conditions', function () {
        $arr = [
            ['type' => 'fruit', 'name' => 'apple'],
            ['type' => 'fruit', 'name' => 'banana'],
            ['type' => 'vegetable', 'name' => 'carrot'],
        ];
        $filtered = Support::filter($arr, ['type' => 'fruit']);
        expect($filtered)->toHaveCount(2);
    });

    test('objectToArray converts object to array', function () {
        $obj = new class () {
            public $foo = 'bar';
            public function bar()
            {
                return 'baz';
            }
            private $hidden = 'secret';
        };
        $arr = Support::objectToArray($obj);
        expect($arr)->toHaveKey('foo');
        expect($arr)->toHaveKey('methods');
        expect($arr['methods'])->toContain('bar');
        expect($arr)->not->toHaveKey('hidden');
    });
});
