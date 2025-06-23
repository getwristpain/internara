<?php

use App\Helpers\Generator;

describe('Generator', function () {
    test('generates a key with default parameters', function () {
        $key = Generator::key();
        expect($key)->toBeString()
            ->and(strlen($key))->toBe(32);
    });

    test('generates a key with identifier', function () {
        $key = Generator::key('test-identifier');
        expect($key)->toBeString()
            ->and(strlen($key))->toBe(32);
    });

    test('generates a key with timestamp', function () {
        $key = Generator::key('test', true);
        $parts = explode('-', $key);

        expect(count($parts))->toBe(3)
            ->and(strlen($parts[2]))->toBe(32);
    });

    test('generates different keys for different identifiers', function () {
        $key1 = Generator::key('id1');
        $key2 = Generator::key('id2');
        expect($key1)->not()->toBe($key2);
    });

    test('generates different keys on each call', function () {
        $key1 = Generator::key();
        $key2 = Generator::key();
        expect($key1)->not()->toBe($key2);
    });
});
