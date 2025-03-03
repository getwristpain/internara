<?php

namespace App\Livewire\Installations;

use Livewire\Attributes\{On, Layout, Title};
use Livewire\Component;

#[
    Title('Instalasi | Pengaturan Jurusan'),
    Layout('components.layouts.guest')
]
class InstallDepartment extends Component
{
    public function back()
    {
        return $this->redirectRoute('install.school', navigate: true);
    }

    #[On('department-setting-saved')]
    public function next()
    {
        return $this->redirectRoute('install.owner', navigate: true);
    }

    public function render()
    {
        return view('livewire.installations.install-department');
    }
}
