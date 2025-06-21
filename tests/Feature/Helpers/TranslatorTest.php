<?php

use App\Helpers\Translator;

describe('Translator', function () {
    it('translates a plain string message as-is', function () {
        $expected = __('Application has been tested successfully.', [], 'en');
        $result = Translator::translate('Application has been tested successfully.', [], 'en');
        expect($result)->toBe($expected);
    });

    it('translates a message using a translation key', function () {
        $expected = __('tests.message', [], 'en');
        $result = Translator::translate('tests.message', [], 'en');
        expect($result)->toBe($expected);
    });

    it('translates a message with resource replacement using translation key', function () {
        $expected = __('tests.success.tested', ['resource' => __('tests.resources.app', [], 'en')], 'en');
        $result = Translator::translate('tests.success.tested', ['resource' => 'App'], 'en');
        expect($result)->toBe($expected);
    });

    it('translates a message with resource replacement using custom locale', function () {
        $expected = __('tests.success.tested', ['resource' => __('tests.resources.app', [], 'id')], 'id');
        $result = Translator::translate('tests.success.tested', ['resource' => 'App'], 'id');
        expect($result)->toBe($expected);
    });
});
