<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke()
    {
        $response = app(\App\Services\AuthService::class)->logout();
        return $response->passes()
            ? redirect('/')
            : session()->flash('error', $response->getMessage());
    }
}
