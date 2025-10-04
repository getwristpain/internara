<?php

use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest')] class extends Component {
    #[On('owner-registered')]
    public function next(): void
    {
        $this->redirect(route('setup.school'), navigate: true);
    }

    public function rendering(Illuminate\View\View $view): void
    {
        $title = 'Buat Akun Administrator | ' . config('app.name') . ' - ' . config('app.description');
        $view->title($title);
    }
}; ?>

<div class="flex h-full w-full flex-col items-center justify-center">
    <x-partials.setup.navigation previous="Selamat Datang" previousUrl="{{ route('setup') }}"
        label="Konfigurasi Akun Administrator" current="2" />

    <div class="flex w-full flex-1 items-center justify-center">
        <livewire:auth.register title="Buat Akun Administrator" description="Kelola sistem dengan akun pusat."
            type="owner" bordered />
    </div>
</div>
