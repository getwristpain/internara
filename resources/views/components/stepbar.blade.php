@props([
    'currentStep' => '',
    'steps' => '',
    'title' => '',
])

<div class="flex flex-col w-full gap-4 min-h-20">
    <div class="flex items-center justify-between text-xs text-gray-400">
        <span class="text-subheading">{{ $title }}</span>
        <span><span class="font-bold">{{ $currentStep }}</span>/{{ $steps }}</span>
    </div>
    <div class="flex w-full">
        <div class="relative flex items-center w-full h-2 rounded-full bg-primary bg-opacity-10">
            <div class="absolute flex items-center justify-between w-full">
                @for ($i = 1; $i < $steps; $i++)
                    <div
                        class="flex items-center justify-center w-full h-2 {{ $currentStep > $i ? 'bg-primary bg-opacity-70' : 'bg-primary-100' }}">
                        <span class="before:content-['']"></span>
                    </div>
                @endfor
            </div>
            <div class="absolute flex items-center justify-between w-full gap-4">
                @for ($i = 0; $i < $steps; $i++)
                    <div
                        class="flex items-center justify-center w-6 h-6 rounded-full font-bold text-xs text-base-100 {{ $currentStep > $i ? 'bg-primary' : 'bg-primary-100' }}">
                        @if ($currentStep > $i)
                            <iconify-icon icon="mingcute:check-fill"></iconify-icon>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
