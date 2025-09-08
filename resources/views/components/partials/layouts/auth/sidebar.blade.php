@props([
    'menu' => config('menu'),
])

<div
    class="scrollbar-hidden sticky z-10 min-h-screen w-fit bg-gradient-to-b from-neutral-50 to-neutral-200 p-2 font-medium text-neutral-500">
    <div class="flex h-full flex-col items-center justify-between gap-8">
        <div class="flex flex-col gap-2">
            @foreach ($menu as $item)
                @php
                    $active = request()->routeIs($item['route'] ?? '');
                @endphp

                @if (!empty($item['submenu']))
                    <div class="w-full" x-data="{
                        open: false
                    }">
                        <div class="group relative z-10 flex w-full max-w-full cursor-pointer items-center overflow-x-visible shadow-neutral-300 hover:rounded-l-xl hover:bg-neutral-200"
                            x-on:click="open = !open">
                            <span
                                class="btn btn-square {{ $active ? 'bg-neutral-900 text-neutral-100' : 'bg-inherit text-inherit' }} rounded-xl border-none">
                                <iconify-icon icon="{{ $item['icon'] ?? 'mingcute:right-fill' }}"></iconify-icon>
                            </span>

                            <div
                                class="wh-full {{ $active ? 'group-hover:bg-neutral-900 group-hover:text-neutral-100' : 'group-hover:bg-neutral-200' }} absolute z-10 hidden min-w-32 translate-x-10 rounded-r-xl p-2 transition duration-150 ease-in-out group-hover:block">
                                <div class="flex items-center justify-between gap-1">
                                    <span>
                                        {{ $item['label'] ?? 'Untitled' }}
                                    </span>

                                    <iconify-icon class="transition-transform duration-200"
                                        x-bind:class="(open ? 'rotate-180' : '')"
                                        icon="icon-park-solid:down-one"></iconify-icon>
                                </div>
                            </div>
                        </div>

                        <div class="w-full" x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 -translate-y-10"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-10">
                            @foreach ($item['submenu'] as $submenu)
                                @php
                                    $active = request()->routeIs($submenu['route'] ?? '');
                                @endphp

                                <a class="{{ $active ? 'hover:bg-neutral-900' : 'hover:bg-neutral-200' }} group relative flex w-full max-w-full cursor-pointer items-center overflow-x-visible shadow-neutral-300 hover:rounded-l-xl"
                                    href="{{ route($submenu['route'] ?? 'home') }}" wire:navigate>
                                    <span
                                        class="btn btn-square {{ $active ? 'bg-neutral-900 text-neutral-100' : 'bg-inherit text-inherit' }} rounded-xl border-none">
                                        <iconify-icon
                                            icon="{{ $submenu['icon'] ?? 'mingcute:right-fill' }}"></iconify-icon>
                                    </span>

                                    <span
                                        class="wh-full {{ $active ? 'group-hover:bg-neutral-900 group-hover:text-neutral-100' : 'group-hover:bg-neutral-200' }} absolute z-10 hidden min-w-32 translate-x-10 rounded-r-xl p-2 transition duration-150 ease-in-out group-hover:block">{{ $submenu['label'] ?? 'Untitled' }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a class="{{ $active ? 'hover:bg-neutral-900' : 'hover:bg-neutral-200' }} group relative flex w-full max-w-full cursor-pointer items-center overflow-x-visible shadow-neutral-300 hover:rounded-l-xl"
                        href="{{ route($item['route'] ?? 'home') }}" wire:navigate>
                        <span
                            class="btn btn-square {{ $active ? 'bg-neutral-900 text-neutral-100' : 'bg-inherit text-inherit' }} rounded-xl border-none">
                            <iconify-icon icon="{{ $item['icon'] ?? 'mingcute:right-fill' }}"></iconify-icon>
                        </span>

                        <span
                            class="wh-full {{ $active ? 'group-hover:bg-neutral-900 group-hover:text-neutral-100' : 'group-hover:bg-neutral-200' }} absolute z-10 hidden min-w-32 translate-x-10 rounded-r-xl p-2 transition duration-150 ease-in-out group-hover:block">{{ $item['label'] ?? 'Untitled' }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>
