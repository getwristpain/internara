<?php

use App\Helpers\LogicResponse;
use App\Livewire\Forms\DepartmentForm;
use App\Models\Department;
use App\Services\SetupService;
use function Livewire\Volt\{state, layout, title, form, mount, protect};

state([
    'departments' => [],
]);

layout('components.layouts.guest');

title(fn() => App\Helpers\Transform::from('Atur Jurusan Sekolah | :app_desc')->replace(':app_desc', config('app.description'))->toString());

form(DepartmentForm::class);

mount(function () {
    $this->initialize();
    $this->ensureReqStepsCompleted();
});

$initialize = protect(function () {
    $departments = Department::query()->orderBy('name')->get();
    $this->departments = $departments
        ->map(
            fn($department) => [
                'id' => $department->id,
                'name' => $department->name,
                'description' => $department->description,
            ],
        )
        ->toArray();
});

$ensureReqStepsCompleted = protect(function () {
    $service = app(SetupService::class);
    $res = $service->ensureStepsCompleted('setup:school');

    if ($res->fails()) {
        flash()->error($res->getMessage());
        $this->redirectRoute('setup.school', navigate: true);
    }
});

$add = function () {
    $res = $this->form->submit();
    $res->passes() ? $this->initialize() : flash()->error($res->getMessage());
};

$delete = function ($id) {
    Department::find($id)->delete();
};

$next = function () {
    $service = app(SetupService::class);
    $res = $service->perform('setup:department');

    $res->passes() ? $this->redirectRoute('setup.program', navigate: true) : flash()->error($res->getMessage());
};

?>

<div class="flex-1 flex flex-col gap-8 items-center justify-center pt-16 w-full max-w-4xl mx-auto">
    <div class="w-full text-center">
        <x-animate.fade-in>
            <h1 class="text-xl md:text-2xl lg:text-4xl font-black text-neutral">
                Atur Jurusan Sekolah
            </h1>
        </x-animate.fade-in>

        <x-animate.fade-in delay="200ms">
            <p class="md:text-lg lg:text-xl text-neutral-600">
                Tambah dan kurang jurusan sekolah Anda dengan fleksibel.
            </p>
        </x-animate.fade-in>
    </div>

    <x-animate.fade-in class="flex-1 w-full" delay="400ms">
        @include('partials.department.department-list')
    </x-animate.fade-in>

    <x-animate.fade-in class="w-full flex justify-end items-center" delay="200ms">
        <x-button class="btn-wide md:btn-lg" label="Lanjutkan" action="next" color="primary" />
    </x-animate.fade-in>
</div>
