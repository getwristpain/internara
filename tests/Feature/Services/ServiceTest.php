<?php

use App\Helpers\ModelWrapper;
use App\Services\Service;
use App\Helpers\LogicResponse;
use Tests\Dummies\DummyService;

describe('Base Service Class', function () {
    beforeEach(function () {
        $this->service = new DummyService();
    });

    it('casts service to string via __toString()', function () {
        expect((string) $this->service)->toBeString();
    });

    it('wraps the model properly via model()', function () {
        expect($this->service->model())->toBeInstanceOf(ModelWrapper::class);
    });

    it('builds logic response with type and payload via response()', function () {
        $res = $this->service->response();

        expect($res)->toBeInstanceOf(LogicResponse::class);
        expect($res->getType())->toBe('DummyService');
        expect($res->payload())->toHaveKeys(['data', 'meta']);
    });

    it('returns validation failure if input is invalid', function () {
        $res = $this->service->validate(['name' => ''], ['name' => 'required']);

        expect($res->fails())->toBeTrue();
        expect($res->getErrors())->not->toBeEmpty();
    });

    it('returns validation success if input is valid', function () {
        $res = $this->service->validate(['name' => 'Valid']);

        expect($res->passes())->toBeTrue();
        expect($res->payload()['data']['name'])->toBe('Valid');
    });

    it('skips validation if no rules are defined', function () {
        $noRuleService = new class () extends Service {};
        $res = $noRuleService->validate(['foo' => 'bar']);

        expect($res->passes())->toBeTrue();
        expect($res->payload()['data']['foo'])->toBe('bar');
    });

    it('returns correct data via data()', function () {
        $this->service->withData(['role' => 'admin']);
        expect($this->service->data('role'))->toBe('admin');
        expect($this->service->data('missing', 'default'))->toBe('default');
    });

    it('returns correct meta via meta()', function () {
        $this->service->withMeta(['env' => 'test']);
        expect($this->service->meta('env'))->toBe('test');
        expect($this->service->meta('missing', 'fallback'))->toBe('fallback');
    });

    it('returns data and meta via toArray()', function () {
        $this->service->withData(['x' => 1])->withMeta(['y' => 2]);
        $arr = $this->service->toArray();

        expect($arr)->toBeArray();
        expect($arr)->toHaveKeys(['data', 'meta']);
    });

    it('sets data and meta via withData() and withMeta()', function () {
        $this->service->withData(['a' => 1])->withMeta(['b' => 2]);

        expect($this->service->data('a'))->toBe(1);
        expect($this->service->meta('b'))->toBe(2);
    });
});
