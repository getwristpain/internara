<?php

use App\Helpers\Debugger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

describe('Debugger', function () {
    beforeEach(function () {
        Request::swap(app('request'));
        Auth::shouldReceive('id')->andReturn(42);
    });

    test('can be instantiated from string', function () {
        $debugger = Debugger::from('Something went wrong');

        expect($debugger->exception())->toBeInstanceOf(Exception::class);
        expect($debugger->exception()->getMessage())->toBe('Something went wrong');
    });

    test('can be instantiated from exception object', function () {
        $exception = new Exception('Boom');
        $debugger = Debugger::from($exception);

        expect($debugger->exception())->toBe($exception);
    });

    test('adds properties correctly', function () {
        $debugger = Debugger::from('error')->withProperties(['foo' => 'bar']);

        $props = $debugger->getProperties();

        expect($props)
            ->toHaveKey('foo', 'bar')
            ->toHaveKey('clientIp')
            ->toHaveKey('userAgent');
    });

    test('handle() returns instance without throwing', function () {
        $debugger = Debugger::handle('error', [], throw: false, log: false);

        expect($debugger)->toBeInstanceOf(Debugger::class);
        expect($debugger->exception()->getMessage())->toBe('error');
    });

    test('throwIf() throws when condition is true', function () {
        $debugger = Debugger::from('error');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('error');

        $debugger->throwIf(true);
    });

    test('throwIf() does not throw when condition is false', function () {
        $debugger = Debugger::from('error');

        expect(fn () => $debugger->throwIf(false))->not->toThrow(Exception::class);
    });

    test('abortIf() aborts when condition is true', function () {
        $debugger = Debugger::from('Aborting...');
        $code = 418;

        $this->expectException(Symfony\Component\HttpKernel\Exception\HttpException::class);
        $this->expectExceptionMessage('Aborting...');

        $debugger->abortIf(true, $code);
    });

    test('toArray() contains correct keys', function () {
        $debugger = Debugger::from('Array me')->withProperties(['foo' => 'bar']);

        $data = $debugger->toArray();

        expect($data)->toHaveKeys([
            'message',
            'code',
            'file',
            'line',
            'stack',
            'properties',
        ]);

        expect($data['properties'])->toHaveKey('foo', 'bar');
    });
});
