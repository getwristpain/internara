<?php

use App\Helpers\Helper;
use Tests\Dummies\Dummy;

describe('Helper', function () {

    describe('stringify', function () {
        test('converts scalar values to string', function () {
            expect(Helper::stringify('hello'))->toBe('hello');
            expect(Helper::stringify(true))->toBe('true');
            expect(Helper::stringify(false))->toBe('false');
            expect(Helper::stringify(123))->toBe('123');
            expect(Helper::stringify(12.34))->toBe('12.34');
            expect(Helper::stringify(null))->toBe('NULL');

            $array = ['foo' => 1, 'bar' => 2];
            expect(Helper::stringify($array))->toBe(json_encode($array, JSON_PRETTY_PRINT));
        });
    });

    describe('hasNestedArray', function () {
        test('returns true when the array has nested arrays', function () {
            expect(Helper::hasNestedArray([1, [2], 3]))->toBeTrue();
        });

        test('returns false when the array is flat', function () {
            expect(Helper::hasNestedArray([1, 2, 3]))->toBeFalse();
        });
    });

    describe('isFlatAssocArray', function () {
        test('returns true for flat associative arrays', function () {
            expect(Helper::isFlatAssocArray(['a' => 1]))->toBeTrue();
            expect(Helper::isFlatAssocArray(['name' => 'John']))->toBeTrue();
        });

        test('returns false for numeric arrays', function () {
            expect(Helper::isFlatAssocArray([1, 2, 3]))->toBeFalse();
        });

        test('returns false for numeric-string keys', function () {
            expect(Helper::isFlatAssocArray(['1' => 'one', '2' => 'two']))->toBeFalse();
        });

        test('returns false and logs error for integer keys', function () {
            expect(Helper::isFlatAssocArray([0 => 'a']))->toBeFalse();
        });
    });

    describe('getArray', function () {
        test('returns value by simple key', function () {
            $arr = ['a' => 1];

            expect(Helper::getArray($arr, 'a'))->toBe(1);
            expect(Helper::getArray($arr, 'b', 'default'))->toBe('default');
        });

        test('returns nested value using path array', function () {
            $arr = ['a' => ['b' => ['c' => 5]]];

            expect(Helper::getArray($arr, ['a', 'b', 'c']))->toBe(5);
            expect(Helper::getArray($arr, ['a', 'x'], 'not found'))->toBe('not found');
        });

        test('returns default when key is empty', function () {
            $arr = [];

            expect(Helper::getArray($arr))->toBe(null);
            expect(Helper::getArray($arr, '', 'fallback'))->toBe('fallback');
        });
    });

    describe('setArray', function () {
        test('sets value by simple key', function () {
            $arr = [];

            Helper::setArray($arr, 'name', 'testing');

            expect($arr)->toBe(['name' => 'testing']);
        });

        test('sets value by nested path', function () {
            $arr = [];

            Helper::setArray($arr, ['a', 'b', 'c'], 123);

            expect($arr)->toBe(['a' => ['b' => ['c' => 123]]]);
        });
    });

    describe('getKeysWithKeywords', function () {
        test('returns keys containing the given keywords', function () {
            $arr = ['username' => 'a', 'email' => 'b', 'phone' => 'c'];
            $expected = ['username', 'email'];

            expect(Helper::getKeysWithKeywords($arr, ['user', 'mail']))->toBe($expected);
        });
    });

    describe('filter', function () {
        test('filters using a callback condition', function () {
            $arr = ['a' => 1, 'b' => 2, 'c' => 0];

            expect(Helper::filter($arr, fn ($v) => $v > 0))->toBe(['a' => 1, 'b' => 2]);
        });

        test('filters by keywords (include mode)', function () {
            $arr = ['email_address' => 'a', 'name' => 'b'];

            expect(Helper::filter($arr, ['keywords' => ['email']]))->toBe(['email_address' => 'a']);
        });

        test('filters by keywords (exclude mode)', function () {
            $arr = ['email_address' => 'a', 'name' => 'b'];

            expect(Helper::filter($arr, ['keywords' => ['email'], 'exclude' => true]))->toBe(['name' => 'b']);
        });

        test('filters by matching key-value pairs', function () {
            $arr = [
                ['type' => 'book', 'active' => true],
                ['type' => 'magazine', 'active' => false],
            ];

            $expected = [['type' => 'book', 'active' => true]];

            expect(Helper::filter($arr, ['type' => 'book']))->toBe($expected);
        });

        test('filters by selected keys from an indexed array', function () {
            $arr = ['name' => 'a', 'role' => 'b', 'email' => 'c'];
            $expected = ['name' => 'a', 'email' => 'c'];

            expect(Helper::filter($arr, ['name', 'email']))->toBe($expected);
        });

        test('removes falsy values by default', function () {
            $arr = ['a', '', null, 0, false, 'ok'];

            expect(Helper::filter($arr))->toBe([0 => 'a', 5 => 'ok']);
        });
    });

    describe('objectToArray', function () {
        test('converts public properties and method names to array', function () {
            $model = new Dummy(['name' => 'Testing']);
            $result = Helper::objectToArray($model);

            expect($result)->toMatchArray([
                'properties' => ['name' => 'Testing'],
                'methods' => ['greet'],
            ]);
        });
    });

});
