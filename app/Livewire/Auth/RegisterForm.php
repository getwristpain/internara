<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use App\Services\AuthService;
use Illuminate\View\View;

class RegisterForm extends Component
{
    /**
     * @var AuthService The service to handle authentication logic.
     */
    protected AuthService $service;

    /**
     * @var User|null The user model instance.
     */
    public ?User $user = null;

    /**
     * @var string The user's role type.
     */
    #[Reactive]
    public string $type = 'student';

    /**
     * @var array The form data for the user.
     */
    public array $data = [];

    /**
     * @var string|null The form's title.
     */
    public ?string $title = null;

    /**
     * @var string|null The form's description.
     */
    public ?string $desc = null;

    /**
     * @var bool Determines if the form has a border.
     */
    public bool $bordered = false;

    /**
     * @var bool Determines if the form has a shadow.
     */
    public bool $shadowed = false;

    /**
     * @var bool Determines if the form actions are hidden.
     */
    public bool $hideActions = false;

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
     * Mounts the component and initializes the form state.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->initialize();
    }

    /**
     * Sets the user type based on an event.
     *
     * @param string $type The user type.
     * @return void
     */
    #[On('set-user-type')]
    public function setType(string $type): void
    {
        $this->type = $type;
        $this->initialize(true);
    }

    /**
     * Submits the registration form.
     *
     * @return void
     */
    public function submit(): void
    {
        $this->validate(
            rules: [
                'data.name' => 'required|string|max:50',
                'data.email' => 'required|email|unique:users,email,' . ($this->user?->id ?? ''),
                'data.password' => ['required', 'confirmed', Password::auto()],
                'data.password_confirmation' => 'string',
                'data.type' => 'required|string|in:' . implode(',', User::getRolesOptions()),
            ],
            attributes: [
                'data.name' => 'nama pengguna',
                'data.email' => 'email pengguna',
                'data.password' => 'kata sandi pengguna',
                'data.password_confirmation' => 'konfirmasi kata sandi',
                'data.type' => 'tipe akun',
            ],
        );

        $payload = $this->data;

        $response = $this->service
            ->setUser($this->user)
            ->register($payload);

        flash($response->getMessage(), $response->getStatusType());

        if ($response->passes()) {
            $this->initialize();
            $this->dispatch("register-form:registered", $this->type);
        }
    }

    /**
     * Handles exceptions, particularly for validation errors.
     *
     * @param \Throwable $e
     * @param bool $stopPropagation
     * @return void
     */
    public function exception(\Throwable $e, $stopPropagation): void
    {
        if ($e instanceof ValidationException) {
            $errors = $e->validator->errors();
            if ($errors->has('data.type')) {
                $this->addError('data.email', $errors->first('data.type'));
            }
        }
    }

    // ---

    /**
     * Initializes the form state.
     *
     * @param bool $loadData Whether to load data for the owner.
     * @return void
     */
    private function initialize(bool $loadData = true): void
    {
        $this->reset('data');

        $this->data = [
            'name' => null,
            'email' => null,
            'password' => null,
            'password_confirmation' => null,
            'type' => $this->type,
        ];

        if ($this->type === 'owner') {
            $this->data['name'] = 'Administrator';
            if ($loadData) {
                $this->loadOwnerData();
            }
        }
    }

    /**
     * Loads existing owner data if available.
     *
     * @return void
     */
    private function loadOwnerData(): void
    {
        $this->user = User::query()
            ->select(['id', 'name', 'email'])
            ->role('owner')->first();

        if ($this->user) {
            $this->data['name'] = $this->user->name;
            $this->data['email'] = $this->user->email;
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
        $view = view('livewire.auth.register-form');

        return $view->layout('components.layouts.guest', [
            'title' => 'Buat Akun | ' . config('app.description'),
        ]);
    }
}
