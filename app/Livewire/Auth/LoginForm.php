<?php

namespace App\Livewire\Auth;

use App\Services\AuthService;
use Illuminate\View\View;
use Livewire\Component;

class LoginForm extends Component
{
    /**
     * @var AuthService The service to handle authentication logic.
     */
    protected AuthService $service;

    /**
     * @var array The form data for login.
     */
    public array $data = [];

    // ---

    /**
     * The Livewire component's lifecycle hook for dependency injection.
     *
     * @param AuthService $service
     * @return void
     */
    public function boot(AuthService $service): void
    {
        $this->service = $service;
    }

    /**
     * Mounts the component and initializes the form data.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->initialize();
    }

    /**
     * Initializes the component's form data.
     *
     * @return void
     */
    protected function initialize(): void
    {
        $this->reset('data');

        $this->data = [
            'username' => null,
            'password' => null,
            'remember' => false,
        ];
    }

    // ---

    /**
     * Submits the login form and attempts to authenticate the user.
     *
     * @return void
     */
    public function submit(): void
    {
        $this->validate([
            'data.username' => 'required|string|max:50',
            'data.password' => 'required|string|min:5',
            'data.remember' => 'boolean',
        ], attributes: [
            'data.username' => 'username pengguna',
            'data.password' => 'kata sandi',
            'data.remember' => 'ingat saya',
        ]);

        $response = $this->service->login($this->data);

        if ($response->passes()) {
            if (auth()->user()->hasRole('admin')) {
                $this->redirect('/admin', navigate: true);
            } else {
                $this->redirectRoute('dashboard', navigate: true);
            }
        } else {
            flash()->error($response->getMessage());
        }
    }

    // ---

    /**
     * Renders the component's view with a guest layout.
     *
     * @return View
     */
    public function render(): View
    {
        /**
         * @var View $view
         */
        $view = view('livewire.auth.login-form');

        return $view->layout('components.layouts.full', [
            'title' => 'Masuk | ' . setting()->cached('brand_name'),
        ]);
    }
}
