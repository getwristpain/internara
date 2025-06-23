<?php

use App\Helpers\Debugger;
use App\Helpers\LogicResponse;
use App\Contracts\DebuggerContract;

describe('Debugger', function () {
    test('implements DebuggerContract', function () {
        $debugger = new Debugger();
        expect($debugger)->toBeInstanceOf(DebuggerContract::class);
    });

    test('can create a debug instance', function () {
        $exception = new Exception('Test exception');
        $debugger = Debugger::debug($exception, 'Custom message', ['foo' => 'bar'], ['baz' => 'qux']);
        expect($debugger)->toBeInstanceOf(Debugger::class)
            ->and($debugger->getMessage())->toBe('Custom message')
            ->and($debugger->exception())->toBe($exception)
            ->and($debugger->getContext())->toBe(['foo' => 'bar'])
            ->and($debugger->getProperties())->toHaveKey('baz');
    });

    test('can check debug mode', function () {
        expect(Debugger::isDebug())->toBeBool();
    });

    test('returns a LogicResponse instance', function () {
        $debugger = Debugger::debug(new Exception('Test'));
        expect($debugger->response())->toBeInstanceOf(LogicResponse::class);
    });

    test('returns the exception instance', function () {
        $exception = new Exception('Test');
        $debugger = Debugger::debug($exception);
        expect($debugger->exception())->toBe($exception);
    });

    test('returns the debug message', function () {
        $exception = new Exception('Test');
        $debugger = Debugger::debug($exception, 'My message');
        expect($debugger->getMessage())->toBe('My message');
    });

    test('returns the debug context', function () {
        $exception = new Exception('Test');
        $debugger = Debugger::debug($exception, '', ['foo' => 'bar']);
        expect($debugger->getContext())->toBe(['foo' => 'bar']);
    });

    test('returns the debug properties', function () {
        $exception = new Exception('Test');
        $debugger = Debugger::debug($exception, '', [], ['baz' => 'qux']);
        expect($debugger->getProperties())->toHaveKey('baz');
    });

    test('throws the exception', function () {
        $exception = new Exception('Throw me');
        $debugger = Debugger::debug($exception);
        expect(fn () => $debugger->throw())->toThrow(Exception::class);
    });

    test('throws if condition is true', function () {
        $exception = new Exception('Throw if');
        $debugger = Debugger::debug($exception);
        expect(fn () => $debugger->throwIf(true))->toThrow(Exception::class);
    });

    test('does not throw if condition is false', function () {
        $exception = new Exception('No throw');
        $debugger = Debugger::debug($exception);
        expect(fn () => $debugger->throwIf(false))->not->toThrow(Exception::class);
    });

    test('throws unless condition is false', function () {
        $exception = new Exception('Throw unless');
        $debugger = Debugger::debug($exception);
        expect(fn () => $debugger->throwUnless(false))->toThrow(Exception::class);
    });

    test('does not throw unless condition is true', function () {
        $exception = new Exception('No throw unless');
        $debugger = Debugger::debug($exception);
        expect(fn () => $debugger->throwUnless(true))->not->toThrow(Exception::class);
    });

    test('returns debug data as array', function () {
        $exception = new Exception('Test');
        $debugger = Debugger::debug($exception, 'Array message', [], ['foo' => 'bar']);
        $array = $debugger->toArray();
        expect($array)->toBeArray()
            ->and($array)->toHaveKey('message')
            ->and($array)->toHaveKey('foo');
    });
});
