<?php

use App\Helpers\Debugger;
use App\Helpers\LogicResponse;
use App\Contracts\DebuggerContract;

it('implements DebuggerContract', function () {
    $debugger = new Debugger();
    expect($debugger)->toBeInstanceOf(DebuggerContract::class);
});

it('can create a debug instance', function () {
    $exception = new Exception('Test exception');
    $debugger = Debugger::debug($exception, 'Custom message', ['foo' => 'bar'], ['baz' => 'qux']);
    expect($debugger)->toBeInstanceOf(Debugger::class);
    expect($debugger->getMessage())->toBe('Custom message');
    expect($debugger->exception())->toBe($exception);
    expect($debugger->getContext())->toBe(['foo' => 'bar']);
    expect($debugger->getProperties())->toHaveKey('baz');
});

it('can check debug mode', function () {
    expect(Debugger::isDebug())->toBeBool();
});

it('returns a LogicResponse instance', function () {
    $debugger = Debugger::debug(new Exception('Test'));
    expect($debugger->response())->toBeInstanceOf(LogicResponse::class);
});

it('returns the exception instance', function () {
    $exception = new Exception('Test');
    $debugger = Debugger::debug($exception);
    expect($debugger->exception())->toBe($exception);
});

it('returns the debug message', function () {
    $exception = new Exception('Test');
    $debugger = Debugger::debug($exception, 'My message');
    expect($debugger->getMessage())->toBe('My message');
});

it('returns the debug context', function () {
    $exception = new Exception('Test');
    $debugger = Debugger::debug($exception, '', ['foo' => 'bar']);
    expect($debugger->getContext())->toBe(['foo' => 'bar']);
});

it('returns the debug properties', function () {
    $exception = new Exception('Test');
    $debugger = Debugger::debug($exception, '', [], ['baz' => 'qux']);
    expect($debugger->getProperties())->toHaveKey('baz');
});

it('can dump debug info', function () {
    $exception = new Exception('Test');
    $debugger = Debugger::debug($exception);

    ob_start();
    $debugger->dump();
    $output = ob_get_clean();

    expect($output)->toBeString();
});

it('throws the exception', function () {
    $exception = new Exception('Throw me');
    $debugger = Debugger::debug($exception);
    expect(fn () => $debugger->throw())->toThrow(Exception::class);
});

it('throws if condition is true', function () {
    $exception = new Exception('Throw if');
    $debugger = Debugger::debug($exception);
    expect(fn () => $debugger->throwIf(true))->toThrow(Exception::class);
});

it('does not throw if condition is false', function () {
    $exception = new Exception('No throw');
    $debugger = Debugger::debug($exception);
    expect(fn () => $debugger->throwIf(false))->not->toThrow(Exception::class);
});

it('throws unless condition is true', function () {
    $exception = new Exception('Throw unless');
    $debugger = Debugger::debug($exception);
    expect(fn () => $debugger->throwUnless(false))->toThrow(Exception::class);
});

it('does not throw unless condition is true', function () {
    $exception = new Exception('No throw unless');
    $debugger = Debugger::debug($exception);
    expect(fn () => $debugger->throwUnless(true))->not->toThrow(Exception::class);
});

it('returns debug data as array', function () {
    $exception = new Exception('Test');
    $debugger = Debugger::debug($exception, 'Array message', [], ['foo' => 'bar']);
    $array = $debugger->toArray();
    expect($array)->toBeArray();
    expect($array)->toHaveKey('message');
    expect($array)->toHaveKey('foo');
});
