@props([
    'class' => '',
    'show' => '',
])

<div x-show="{{ $show }}" x-cloak
    x-on:keydown.escape.window="{{ $show }} = false"
    x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    x-cloak>

    <div
        class="wh-full glass z-9 fixed left-0 top-0 min-h-screen overflow-y-auto overflow-x-hidden">
        <div x-show="{{ $show }}" x-cloak
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-10">

            <div
                class="wh-full container mx-auto flex flex-col items-center justify-center p-4 pt-24 md:p-8 lg:p-16">
                <div class="{{ $class }} relative h-fit w-fit overflow-visible rounded-xl border border-neutral-900 p-4 shadow-lg shadow-neutral-400"
                    x-on:click.outside="{{ $show }} = false">
                    <button
                        class="btn btn-circle btn-xs absolute right-4 top-4 z-10 border border-red-500 bg-red-100 hover:bg-red-200"
                        x-on:click="{{ $show }} = false">
                        <x-icon class="cursor-pointer text-red-500"
                            icon="mdi:close" />
                    </button>

                    <div
                        class="flex w-full flex-col items-center justify-center">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
