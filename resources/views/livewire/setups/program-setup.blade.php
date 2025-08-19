<?php

use App\Models\Program;
use App\Helpers\Transform;
use App\Services\SetupService;
use App\Livewire\Forms\ProgramForm;
use function Livewire\Volt\{state, layout, title, protect, mount, form};

state([
    'programs' => [],
]);

layout('components.layouts.guest');

title(fn() => Transform::from('Atur Program PKL | :app_desc')->replace(':app_desc', config('app.description'))->toString());

form(ProgramForm::class);

mount(function () {
    $this->initialize();
    $this->ensureReqStepsCompleted();
});

$initialize = protect(function () {
    $this->programs = Program::all()->toArray();
    $this->form->initialize();
});

$ensureReqStepsCompleted = protect(function () {
    $service = app(SetupService::class);
    $res = $service->ensureStepsCompleted('setup:department');

    if ($res->fails()) {
        flash()->error($res->getMessage());
        $this->redirectRoute('setup.department', navigate: true);
    }
});

$addProgram = function () {
    $res = $this->form->submit();
    $res->passes() ? $this->initialize() : flash()->error($res->getMessage());
    $this->dispatch('toggle-program-modal');
};

$next = function () {
    $this->redirectRoute('setup.complete', navigate: true);
};

?>

<div class="flex-1 flex flex-col gap-12 items-center justify-center pt-16">
    <div class="space-y-2 text-center w-full">
        <x-animate.fade-in>
            <h1 class="text-xl md:text-2xl lg:text-4xl font-black text-neutral">Atur Program PKL</h1>
        </x-animate.fade-in>

        <x-animate.fade-in delay="200ms">
            <p class="md:text-lg lg:text-xl text-gray-500">Tambah dan kurang program PKL Anda dengan fleksibel.</p>
        </x-animate.fade-in>
    </div>

    <x-animate.fade-in class="flex-1 w-full" delay="400ms">
        @include('partials.program.program-list')
    </x-animate.fade-in>

    <x-animate.fade-in class="w-full flex justify-end items-center" delay="200ms">
        <x-button class="btn-wide md:btn-lg" label="Simpan dan Lanjutkan" action="next" color="primary" />
    </x-animate.fade-in>
</div>
