<?php

use function Livewire\Volt\{state, layout, title, protect, mount, form};

state([
    'programs' => [],
    'action' => 'add',
]);

layout('components.layouts.guest');
title('Atur Program PKL | ' . config('app.description'));
form(App\Livewire\Forms\ProgramForm::class);

mount(function () {
    $this->ensureReqStepsCompleted();
    $this->initialize();
});

$initialize = protect(function () {
    $this->programs = app(App\Services\ProgramService::class)->getAll();
    $this->form->initialize();
});

$ensureReqStepsCompleted = protect(function () {
    $res = app(App\Services\SetupService::class)->ensureStepsCompleted('setup:department');

    if ($res->fails()) {
        flash()->error($res->getMessage());
        $this->redirectRoute('setup.department', navigate: true);
    }
});

$toggleProgramModal = protect(function ($action = 'add') {
    $this->reset('action');
    $this->action = $action;

    $this->resetValidation();
    $this->dispatch('toggle-program-modal');
});

$add = function () {
    $this->form->add();
    $this->toggleProgramModal();
};

$edit = function ($id) {
    if (!$this->form->edit($id)) {
        flash()->error('Program tidak ditemukan');
        return;
    }

    $this->toggleProgramModal('edit');
};

$remove = function ($id) {
    $this->form->remove($id) ? $this->initialize() : flash()->error('Gagal menghapus program');
    $this->toggleProgramModal();
};

$submit = function () {
    $res = $this->form->submit();
    $res->passes() ? $this->initialize() : flash()->error($res->getMessage());
    $this->toggleProgramModal();
};

$next = function () {
    $res = app(App\Services\SetupService::class)->perform('setup:program');
    $res->passes() ? $this->redirectRoute('setup.complete', navigate: true) : flash()->error($res->getMessage());
};

?>

<div class="flex flex-1 flex-col items-center justify-center gap-8">
    <div class="w-full space-y-2 text-center">
        <x-animate.fade-in>
            <h1 class="text-head">
                Atur Program PKL
            </h1>
        </x-animate.fade-in>

        <x-animate.fade-in delay="200ms">
            <p class="text-subhead">
                Tambah dan kurang program PKL Anda dengan fleksibel.
            </p>
        </x-animate.fade-in>
    </div>

    <x-animate.fade-in class="w-full flex-1" delay="400ms">
        @include('components.partials.program.program-list')
    </x-animate.fade-in>

    <x-animate.fade-in class="flex w-full items-center justify-end"
        delay="200ms">
        <x-button class="btn-wide" label="Simpan dan Lanjutkan" action="next"
            color="primary" shadowed />
    </x-animate.fade-in>
</div>
