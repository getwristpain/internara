<?php

namespace App\Livewire\Auth\Pages;

use App\Services\SystemService;
use Livewire\Component;

class Login extends Component
{
    protected SystemService $systemService;

    public function __construct()
    {
        $this->systemService = app(SystemService::class);
    }

    public function render()
    {
        return view('livewire.auth.pages.login')
            ->extends('layouts.guest', [
                'title' => 'Masuk | '.$this->systemService->first()->name,
            ])
            ->section('content');
    }
}
