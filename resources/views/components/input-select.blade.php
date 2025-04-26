@props([
    'allowCreate' => false,
    'autofocus' => false,
    'badge' => '',
    'disabled' => false,
    'hideDropdownIcon' => false,
    'hideError' => false,
    'hint' => null,
    'label' => null,
    'model' => '',
    'name' => '',
    'options' => '',
    'placeholder' => 'Select or create an option...',
    'required' => false,
    'searchbar' => false,
])

@php
    $badgeClass = match ($badge) {
        'primary' => 'badge badge-primary',
        'secondary' => 'badge badge-secondary',
        'neutral' => 'badge badge-neutral',
        'success' => 'badge badge-success',
        'info' => 'badge badge-info',
        'warning' => 'badge badge-warning',
        'error' => 'badge badge-error',
        'ghost' => 'badge badge-ghost',
        'outline-neutral' => 'badge badge-outline badge-neutral',
        default => '',
    };
@endphp

<div {{ $attributes->merge(['class' => $disabled ? 'disabled' : '']) }}>
    <div class="flex flex-col w-full gap-2">
        <div class="flex flex-col w-full gap-2">
            <x-label :name="$name" :label="$label" :required="$required" :hint="$hint" />

            <div class="relative flex flex-col w-full" x-data="{
                open: false,
                search: '',
                selected: @entangle($model).live,
                options: @entangle($options).live,
                allowCreate: @js($allowCreate),
                showSearch: @js($searchbar),
                filteredOptions() {
                    return this.options.filter(opt => opt.label.toLowerCase().includes(this.search.toLowerCase()));
                },
                isCreatingNew() {
                    return this.allowCreate && this.search.trim() !== '' && this.filteredOptions().length === 0;
                },
                addOption() {
                    if (this.isCreatingNew()) {
                        @this.set('{{ $options }}', [...@this.get('{{ $options }}'), { value: this.search, label: this.search }]);
                        this.selected = this.search;
                        this.open = false;
                        this.search = '';
                    }
                }
            }">
                <div x-data="{
                    rotated: false
                }"
                    @click="if (!{{ $disabled ? 'true' : 'false' }}) { open = !open } { rotated = !rotated}"
                    tabindex="0" title="{{ $placeholder }}">
                    <div
                        class="flex gap-4 justify-between w-full items-center overflow-hidden cursor-pointer input input-bordered focus:ring-2 focus:ring-neutral pt-1 {{ $disabled ? 'disabled' : '' }}">
                        <span><iconify-icon class="text-gray-400 scale-125" icon="tabler:selector"></iconify-icon></span>
                        <span class="overflow-x-hidden w-full text-gray-500 text-nowrap {{ $badgeClass }}"
                            x-text="filteredOptions().find(option => option.value === selected)?.label || '{{ $placeholder }}'"></span>
                        @if (!$hideDropdownIcon)
                            <span><iconify-icon class="text-gray-400 scale-125" :class="{ 'rotate-180': rotated }"
                                    icon="icon-park-outline:down-c"></iconify-icon></span>
                        @endif
                    </div>
                </div>

                <div class="absolute z-50 w-full border border-gray-300 rounded-lg bg-base top-12" x-show="open"
                    @click.away="open = false" @keydown.window.escape="open = false" tabindex="0">
                    <!-- Search Input -->
                    <template x-if="showSearch">
                        <input class="w-full p-2 border rounded-t-md" type="text" x-model="search"
                            placeholder="{{ 'Cari ' . $placeholder }}" style="font-size: inherit;"
                            {{ $disabled ? 'disabled' : '' }} {{ $required ? 'required' : '' }} autofocus
                            tabindex="0" />
                    </template>

                    <!-- Options List -->
                    <div class="overflow-y-auto max-h-60">
                        <template x-for="option in filteredOptions()" :key="option.value">
                            <div class="p-2 cursor-pointer hover:bg-white/70 basic-transition"
                                @click="if (!{{ $disabled ? 'true' : 'false' }}) {
                                selected = option.value;
                                open = false;
                                search = '';
                            }"
                                tabindex="0">
                                <span x-text="option.label"></span>
                            </div>
                        </template>
                    </div>

                    <!-- Create New Option -->
                    <template x-if="isCreatingNew()">
                        <div class="p-2 cursor-pointer hover:bg-white/70 basic-transition" @click="addOption()"
                            tabindex="0">
                            <span x-text="'Create new: ' + search"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        @if ($errors->has($model) && !$hideError)
            <div class="mt-2">
                <x-input-error class="mt-2" :messages="$errors->get($model)" />
            </div>
        @endif
    </div>
</div>
