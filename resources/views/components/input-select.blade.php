@props([
    'allowCreate' => false,
    'autofocus' => false,
    'badge' => '',
    'disabled' => false,
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

<div class="flex flex-col gap-2 w-full font-medium pt-1 {{ $disabled ? 'disabled' : '' }}">
    <div class="flex flex-col w-full gap-2">
        <x-input-label :$name :$label :$required :$hint></x-input-label>

        <div class="relative w-full" x-data="{
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
            <div class="flex w-full gap-2 items-center justify-between cursor-pointer input input-bordered {{ $disabled ? 'opacity-80 cursor-not-allowed' : '' }}"
                @click="if (!{{ $disabled ? 'true' : 'false' }}) { open = !open }">
                <iconify-icon class="text-gray-400 scale-125" icon="tabler:selector"></iconify-icon>
                <span class="flex-1 text-gray-500 {{ $badgeClass }} text-nowrap" style="font-size: inherit;"
                    x-text="filteredOptions().find(option => option.value === selected)?.label || '{{ $placeholder }}'"></span>
                <svg class="inline w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <div class="absolute z-50 w-full mt-1 bg-white border rounded-md" x-show="open" @click.away="open = false">
                <!-- Search Input -->
                <template x-if="showSearch">
                    <input class="w-full p-2 border rounded-t-md" type="text" x-model="search"
                        placeholder="{{ 'Cari ' . $placeholder }}" style="font-size: inherit;"
                        {{ $disabled ? 'disabled' : '' }} {{ $required ? 'required' : '' }} autofocus />
                </template>

                <!-- Options List -->
                <div class="max-h-60 overflow-y-auto">
                    <template x-for="option in filteredOptions()" :key="option.value">
                        <div class="p-2 cursor-pointer hover:bg-gray-100"
                            @click="if (!{{ $disabled ? 'true' : 'false' }}) {
                            selected = option.value;
                            open = false;
                            search = '';
                        }">
                            <span x-text="option.label"></span>
                        </div>
                    </template>
                </div>

                <!-- Create New Option -->
                <template x-if="isCreatingNew()">
                    <div class="p-2 cursor-pointer hover:bg-gray-100" @click="addOption()">
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
