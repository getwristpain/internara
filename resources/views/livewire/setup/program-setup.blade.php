<?php

use function Livewire\Volt\{state};

state();

$next = function () {
    $this->redirect(route('setup.complete'), navigate: true);
};

?>

<div class="flex h-full w-full flex-col items-center justify-center">
    <x-partials.setup.navigation label="Atur Program PKL" current="5" previous="Atur Jurusan" :previousUrl="route('setup.department')" />

    <div>
        // program list
    </div>
</div>
