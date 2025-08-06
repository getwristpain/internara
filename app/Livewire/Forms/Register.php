<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class Register extends Component
{
    public string $title = 'Buat Akun Baru';

    public string $type = 'student';

    public array $label = [
        'owner' => 'Administrator',
        'admin' => 'Administrator',
        'student' => 'Siswa',
        'teacher' => 'Guru',
        'supervisor' => 'Pembimbing'
    ];

    public bool $bordered = false;

    public bool $shadowed = false;

    public function mount()
    {
        $this->title = 'Buat Akun ' . $this->label[$this->type];
    }

    public function submit()
    {
        $this->dispatch("{$this->type}:registered");
    }

    public function render()
    {
        return view('livewire.forms.register');
    }
}
