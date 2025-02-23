<?php

namespace App\Livewire\Installations;

use Livewire\Attributes\{Layout, On, Title};
use Livewire\Component;

#[Title('Instalasi | Pengaturan Data Sekolah')]
#[Layout('components.layouts.guest')]
class InstallSchool extends Component
{
    public function back()
    {
        return $this->redirectRoute('install', navigate: true);
    }

    #[On('school-data-saved')]
    public function handleSchoolSaved()
    {
        return $this->redirectRoute('install.department', navigate: true);
    }

    public function render()
    {
        return view('livewire.installations.install-school');
    }
}
