@props([
    'attributes' => [],
    'name' => '',
    'show' => '',
])

<div id="{{ $name }}" x-cloak x-data="{
    show: @entangle($show).live,
    closeModal() {
        this.show = false;
        $dispatch('modal-closed', { name: '{{ $name }}' });
    }
}" x-init="show = false" x-show="show"
    :class="{ 'fixed top-0 left-0 z-10': show }">
    <div
        class="fixed top-0 left-0 z-10 flex items-center justify-center p-8 overflow-x-hidden overflow-y-auto bg-black wh-screen scrollbar-hidden bg-opacity-20 backdrop-blur-sm">
        <div class="relative w-full max-w-4xl bg-white h-fit min-h-12 rounded-xl" @click.away="closeModal()"
            @keydown.window.escape="closeModal()">
            <div class="flex flex-col w-full overflow-y-visible">
                <div class="relative flex items-center justify-end gap-4 px-8 py-4 font-bold bg-gray-100 rounded-t-xl">
                    @isset($header)
                        <div class="flex-1 w-full flex gap-2 items-center">
                            {{ $header }}
                        </div>
                    @endisset

                    <div class="group">
                        <button class="btn btn-circle btn-sm bg-gray-200 group-hover:bg-gray-300 basic-transition"
                            @click="closeModal()">
                            <iconify-icon class="font-bold text-gray-600 basic-transition group-hover:text-red-600"
                                icon="mdi:close"></iconify-icon>
                        </button>
                    </div>
                </div>

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
