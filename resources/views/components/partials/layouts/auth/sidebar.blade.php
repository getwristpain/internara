@props([
    'menu' => config('menu'),
])

<div
    class="scrollbar-hidden sticky z-10 min-h-screen w-fit bg-gradient-to-b from-neutral-50 to-neutral-200 p-2 font-medium text-neutral-500 lg:p-4">
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
                        <div class="{{ $active ? 'lg:bg-gradient-to-r lg:from-neutral-100 lg:to-neutral-200 text-neutral-900' : '' }} group relative z-10 flex w-full max-w-full cursor-pointer items-center overflow-x-visible shadow-neutral-300 hover:rounded-l-xl max-lg:hover:bg-neutral-200 lg:gap-2 lg:rounded-xl lg:hover:text-neutral-700 lg:hover:shadow-lg lg:hover:outline"
                            x-on:click="open = !open">
                            <span
                                class="btn btn-square {{ $active ? 'max-lg:bg-gradient-to-r from-neutral-100 to-neutral-200' : 'bg-inherit text-inherit' }} rounded-xl border-none lg:group-hover:bg-inherit">
                                <x-icon
                                    icon="{{ $item['icon'] ?? 'mingcute:right-fill' }}" />
                            </span>

                            <div
                                class="wh-full z-10 min-w-32 rounded-r-xl p-2 transition duration-150 ease-in-out max-lg:absolute max-lg:hidden max-lg:translate-x-10 max-lg:group-hover:block max-lg:group-hover:bg-neutral-200">
                                <div
                                    class="flex items-center justify-between gap-1">
                                    <span>
                                        {{ $item['label'] ?? 'Untitled' }}
                                    </span>

                                    <x-icon
                                        class="transition-transform duration-200"
                                        x-bind:class="(open ? 'rotate-180' : '')"
                                        icon="icon-park-solid:down-one" />
                                </div>
                            </div>
                        </div>

                        <div class="w-full" x-show="open" x-cloak
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 -translate-y-10"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-10">
                            @foreach ($item['submenu'] as $submenu)
                                @php
                                    $active = request()->routeIs(
                                        $submenu['route'] ?? '',
                                    );
                                @endphp

                                <a class="{{ $active ? 'lg:bg-gradient-to-r lg:from-neutral-100 lg:to-neutral-200 text-neutral-900' : '' }} group relative flex w-full max-w-full cursor-pointer items-center overflow-x-visible shadow-neutral-300 hover:rounded-l-xl max-lg:hover:bg-neutral-200 lg:gap-2 lg:rounded-xl lg:hover:text-neutral-700 lg:hover:shadow-lg lg:hover:outline"
                                    href="{{ route($submenu['route'] ?? 'home') }}"
                                    wire:navigate>
                                    <span
                                        class="btn btn-square {{ $active ? 'max-lg:bg-gradient-to-r from-neutral-100 to-neutral-200' : 'bg-inherit text-inherit' }} rounded-xl border-none lg:group-hover:bg-inherit">
                                        <x-icon
                                            icon="{{ $submenu['icon'] ?? 'mingcute:right-fill' }}" />
                                    </span>

                                    <span
                                        class="wh-full z-10 min-w-32 rounded-r-xl p-2 transition duration-150 ease-in-out max-lg:absolute max-lg:hidden max-lg:translate-x-10 max-lg:group-hover:block max-lg:group-hover:bg-neutral-200">{{ $submenu['label'] ?? 'Untitled' }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a class="{{ $active ? 'lg:bg-gradient-to-r lg:from-neutral-100 lg:to-neutral-200 text-neutral-900' : '' }} group relative flex w-full max-w-full cursor-pointer items-center overflow-x-visible shadow-neutral-300 hover:rounded-l-xl max-lg:hover:bg-neutral-200 lg:gap-2 lg:rounded-xl lg:hover:text-neutral-700 lg:hover:shadow-lg lg:hover:outline"
                        href="{{ route($item['route'] ?? 'home') }}"
                        wire:navigate>
                        <span
                            class="btn btn-square {{ $active ? 'max-lg:bg-gradient-to-r from-neutral-100 to-neutral-200' : 'bg-inherit text-inherit' }} rounded-xl border-none lg:group-hover:bg-inherit">
                            <x-icon
                                icon="{{ $item['icon'] ?? 'mingcute:right-fill' }}" />
                        </span>

                        <span
                            class="wh-full z-10 min-w-32 rounded-r-xl p-2 transition duration-150 ease-in-out max-lg:absolute max-lg:hidden max-lg:translate-x-10 max-lg:group-hover:block max-lg:group-hover:bg-neutral-200">{{ $item['label'] ?? 'Untitled' }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>
