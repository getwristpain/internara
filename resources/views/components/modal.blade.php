@props([
    'class' => 'p-4 md:p-8',
    'show' => '',
])

<div x-show="{{ $show }}" x-cloak x-on:keydown.escape.window="{{ $show }} = false"
    x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>

    <div class="fixed wh-full min-h-screen glass z-9 top-0 left-0 overflow-x-hidden overflow-y-auto">
        <div x-show="{{ $show }}" x-cloak x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-10">

            <div class="container mx-auto wh-full p-12 pt-24 flex flex-col justify-center items-center">
                <div class="w-fit h-fit border border-neutral rounded-xl relative overflow-visible {{ $class }}"
                    x-on:click.outside="{{ $show }} = false">
                    <button
                        class="btn btn-circle btn-xs bg-red-100 hover:bg-red-200 absolute top-4 right-4 z-10 border border-red-500"
                        x-on:click="{{ $show }} = false">
                        <x-icon class="text-red-500 cursor-pointer" icon="mdi:close" />
                    </button>

                    <div class="w-full flex flex-col items-center justify-center">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
