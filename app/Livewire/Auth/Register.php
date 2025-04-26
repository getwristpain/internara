<?php

namespace App\Livewire\Auth;

use App\Services\SystemService;
use Livewire\Component;

class Register extends Component
{
    protected SystemService $systemService;

    public function __construct()
    {
        $this->systemService = new SystemService;
    }

    public function render()
    {
        $appName = $this->systemService->first()->name;

        return view('livewire.auth.register')
            ->layout('components.layouts.guest', [
                'title' => ('Register | '.$appName),
            ]);
    }
}
