<x-card class="p-4 md:p-8" shadowed bordered>
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center">
            @isset(auth()->user()->avatar_url)
                <div class="aspect-square h-8 w-8">
                    <img class="avatar" src="{{ auth()->user()->avatar_url }}" alt="Avatar">
                </div>
            @endisset

            <span class="font-medium">{{ auth()->user()->name }}</span>
        </div>

        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
            @csrf

            <button class="btn btn-outline btn-neutral rounded-xl" type="submit" form="logoutForm">
                <span>
                    Keluar
                </span>

                <span>
                    <x-icon class="icon-sm" name="tabler-logout" />
                </span>
            </button>
        </form>
    </div>
</x-card>
