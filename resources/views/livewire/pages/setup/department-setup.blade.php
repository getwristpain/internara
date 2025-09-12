<?php

use function Livewire\Volt\{state, layout, title, form, mount, protect};

state([
    'departments' => [],
]);

layout('components.layouts.guest');
title('Atur Jurusan Sekolah | ' . config('app.description'));
form(App\Livewire\Forms\DepartmentForm::class);

mount(function () {
    $this->ensureReqStepsCompleted();
    $this->initialize();
});

$initialize = protect(function () {
    $this->departments = app(App\Services\DepartmentService::class)->getAll();
});

$ensureReqStepsCompleted = protect(function () {
    $res = app(App\Services\SetupService::class)->ensureStepsCompleted('setup:school');
    if ($res->fails()) {
        flash()->error($res->getMessage());
        $this->redirectRoute('setup.school', navigate: true);
    }
});

$add = function () {
    $res = $this->form->submit();
    $res->passes() ? $this->initialize() : flash()->error($res->getMessage());
};

$remove = function ($id) {
    App\Models\Department::destroy($id);
};

$next = function () {
    $res = app(App\Services\SetupService::class)->perform('setup:department');
    $res->passes() ? $this->redirectRoute('setup.program', navigate: true) : flash()->error($res->getMessage());
};

?>

<div class="mx-auto flex w-full max-w-6xl flex-1 flex-col items-center justify-center gap-12 pt-12">
    <div class="w-full space-y-1 text-center">
        <x-ui.animate>
            <h1 class="text-head">
                Atur Jurusan Sekolah
            </h1>
        </x-ui.animate>

        <x-ui.animate delay="200ms">
            <p class="text-subhead">
                Tambah dan kurang jurusan sekolah Anda dengan fleksibel.
            </p>
        </x-ui.animate>
    </div>

    <x-ui.animate class="w-full flex-1" delay="400ms">
        @include('components.partials.department.department-list')
    </x-ui.animate>

    <x-ui.animate class="flex w-full items-center justify-end" delay="200ms">
        <x-ui.button class="btn-wide" label="Lanjutkan" action="next" color="primary" shadowed />
    </x-ui.animate>
</div>
