<?php

namespace App\Livewire\Auth\Pages;

use App\Services\SystemService;
use Livewire\Component;

class ForgotPassword extends Component
{
    protected SystemService $systemService;

    public function __construct()
    {
        $this->systemService = new SystemService;
    }

    public function back()
    {
        return $this->redirectRoute('login');
    }

    public function render()
    {
        return view('livewire.auth.pages.forgot-password')
            ->extends('layouts.guest', [
                'title' => 'Lupa Kata Sandi | '.$this->systemService->first()->name,
            ])
            ->section('content');
    }
}
