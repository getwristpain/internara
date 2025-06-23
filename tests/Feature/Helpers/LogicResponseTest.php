<?php

use App\Helpers\LogicResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\MessageBag;

uses(RefreshDatabase::class);

describe('LogicResponse', function () {
    beforeEach(function () {
        $this->response = new LogicResponse();
    });

    describe('success & failure', function () {
        test('can create a success response', function () {
            $res = $this->response->success('Success message');
            expect($res->passes())->toBeTrue();
            expect($res->getMessage())->toBe('Success message');
            expect($res->getStatus())->toBe('success');
            expect($res->getCode())->toBe(200);
            expect($res->hasErrors())->toBeFalse();
        });

        test('can create a failure response', function () {
            $res = $this->response->failure('Failure message');
            expect($res->fails())->toBeTrue();
            expect($res->getMessage())->toBe('Failure message');
            expect($res->getStatus())->toBe('failed');
            expect($res->getCode())->toBe(0);
            expect($res->hasErrors())->toBeTrue();
            expect($res->getErrors())->toBeInstanceOf(MessageBag::class);
        });

        test('can use static response factory', function () {
            $res = LogicResponse::make(true, 'ok', 'done', 201, 'Type', ['foo' => 'bar']);
            expect($res->passes())->toBeTrue();
            expect($res->getMessage())->toBe('ok');
            expect($res->getStatus())->toBe('done');
            expect($res->getCode())->toBe(201);
            expect($res->getType())->toBe('Type');
            expect($res->payload()->toArray())->toBe(['foo' => 'bar']);
        });
    });

    describe('status, code, type, and message', function () {
        test('can set and get status, code, type, and message', function () {
            $res = $this->response
                ->withStatus('custom')
                ->withCode(123)
                ->withType('TestType')
                ->withMessage('Test message');
            expect($res->getStatus())->toBe('custom');
            expect($res->getCode())->toBe(123);
            expect($res->getType())->toBe('TestType');
            expect($res->getMessage())->toBe('Test message');
        });

        test('can get translated message for specific locale', function () {
            $en = __('tests.message', [], 'en');
            $id = __('tests.message', [], 'id');

            $res = $this->response->withMessage('tests.message');
            expect($res->getMessage('en'))->toBe($en);
            expect($res->getMessage('id'))->toBe($id);
        });
    });

    describe('payload', function () {
        test('can set and get payload', function () {
            $payload = ['foo' => 'bar'];
            $res = $this->response->withPayload($payload);
            expect($res->payload())->toBeInstanceOf(Collection::class);
            expect($res->payload()->toArray())->toBe($payload);
        });

        test('can check isEmpty', function () {
            $res = $this->response->withPayload([]);
            expect($res->isEmpty())->toBeTrue();
            $res = $this->response->withPayload(['foo' => 'bar']);
            expect($res->isEmpty())->toBeFalse();
        });
    });

    describe('errors', function () {
        test('can set and get errors as MessageBag', function () {
            $errors = ['field' => ['Error message']];
            $res = $this->response->failure('fail')->withErrors($errors);
            expect($res->getErrors())->toBeInstanceOf(MessageBag::class);
            expect($res->getErrors()->toArray())->toBe($errors);
            expect($res->hasErrors())->toBeTrue();
        });

        test('can add and clear errors', function () {
            $res = $this->response->failure('fail')->withErrors(['foo' => ['bar']]);
            $res->addErrors('baz', 'qux');
            expect($res->getErrors()->has('baz'))->toBeTrue();
            $res->clearErrors();
            expect($res->hasErrors())->toBeFalse();
            expect($res->getErrors())->toBeNull();
        });
    });

    describe('operator and then', function () {
        test('can set and get operator', function () {
            $obj = new stdClass();
            $res = $this->response->success('ok')->operator($obj);
            expect($res->then())->toBe($obj);
        });

        test('returns self on then if fails', function () {
            $res = $this->response->failure('fail');
            expect($res->then())->toBe($res);
        });
    });

    describe('array and logging', function () {
        test('can convert to array', function () {
            $res = $this->response->success('ok')->withPayload(['foo' => 'bar']);
            $arr = $res->toArray();
            expect($arr)->toBeArray();
            expect($arr['success'])->toBeTrue();
            expect($arr['message'])->toBe('ok');
        });

        test('can store log and activity', function () {
            $res = $this->response->success('ok');
            expect($res->storeLog())->toBeInstanceOf(LogicResponse::class);
            expect($res->storeActivity())->toBeInstanceOf(LogicResponse::class);
        });

        test('can debug on failure', function () {
            $res = $this->response->failure('fail');
            expect($res->debug())->toBeInstanceOf(LogicResponse::class);
        });
    });
});
