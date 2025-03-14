@props([
    'name' => '',
    'show' => '',
])

<div id="{{ $name }}" x-cloax x-data="{
    show: @entangle($show).live,
    closeModal() {
        this.show = !this.show;
        $dispatch('modal-closed', { name: {{ $name }} });
    }
}" x-init="show = false" x-show="show"
    x-transition:enter="fade-enter" x-transition:enter-start="fade-enter-active" x-transition:leave="fade-leave-to"
    x-transition:leave-start="fade-leave-active">
    <div
        class="fixed top-0 left-0 z-10 flex items-center justify-center p-8 overflow-x-hidden overflow-y-auto bg-black wh-screen scrollbar-hidden bg-opacity-20 backdrop-blur-sm">
        <div class="relative w-full max-w-4xl bg-white h-fit min-h-12 rounded-xl" @click.away="closeModal()"
            @keydown.window.escape="closeModal()">
            <div class="absolute top-4 right-4">
                <button @click="closeModal()">
                    <iconify-icon class="font-bold text-red-500" icon="mdi:close"></iconify-icon>
                </button>
            </div>
            <div class="flex flex-col w-full overflow-y-visible">
                @isset($header)
                    <div class="flex items-center gap-4 px-8 py-4 font-bold bg-gray-100 rounded-t-xl">
                        {{ $header }}
                    </div>
                @endisset

                <div class="p-8">
                    {{ $body ?? $slot }}
                </div>

                @isset($footer)
                    <div class="flex items-center justify-end gap-4 px-8 py-4 bg-gray-100 rounded-b-xl">
                        {{ $footer }}
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>
