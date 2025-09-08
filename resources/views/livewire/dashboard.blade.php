<?php

use function Livewire\Volt\{state, layout, title};

layout('components.layouts.app');
title('Dashboard | ' . setting()->cached('brand_name'));

?>

<div class="grid flex-1 grid-cols-1 p-4 md:grid-cols-2 md:p-8 lg:grid-cols-4">
    <x-widget.account />
</div>
