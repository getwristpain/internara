<?php

namespace App\Livewire\Auth\Pages;

use App\Services\SystemService;
use Livewire\Component;

class Register extends Component
{
    protected SystemService $systemService;

    public array $system = [];

    public function __construct()
    {
        $this->systemService = new SystemService;
    }

    public function render()
    {
        return view('livewire.auth.pages.register')
            ->extends('layouts.guest', [
                'title' => 'Daftar Akun | '.$this->systemService->first()->name,
            ])
            ->section('content');
    }
}
