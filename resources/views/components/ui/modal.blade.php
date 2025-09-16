@props([
    'class' => '',
    'show' => '',
])

<div x-data="{
    show: @entangle($show) || false,
    dirty: false,
    close() {
        this.show = this.dirty;
    }
}" x-show="show" x-cloak x-on:keydown.escape.window="close"
    x-on:dirty-loading.window="dirty = $event.detail.loading" x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" x-cloak>

    <div
        class="wh-full glass z-9 fixed left-0 top-0 flex min-h-screen flex-col items-center justify-center overflow-y-auto overflow-x-hidden bg-neutral-50/80">
        <div x-show="show" x-cloak x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-10">

            <div class="container mx-auto flex flex-1 flex-col items-center justify-center p-8 pt-20 lg:p-12">
                <div class="{{ $class }} relative h-fit w-fit overflow-visible rounded-xl border border-neutral-900 p-4 shadow-lg shadow-neutral-400 lg:p-8"
                    x-on:click.outside="close">
                    <button
                        class="btn btn-circle btn-xs absolute right-4 top-4 z-10 border border-red-500 bg-red-100 hover:bg-red-200"
                        x-on:click="close">
                        <iconify-icon class="cursor-pointer text-red-500" icon="mdi:close"></iconify-icon>
                    </button>

                    <div class="flex w-full flex-col items-center justify-center">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
