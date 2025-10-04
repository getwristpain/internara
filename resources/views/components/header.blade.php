<flux:header class="border-b border-zinc-200 dark:border-zinc-600 dark:bg-zinc-900" container>
    {{--  Sidebar Toggle --}}
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    {{-- Brand Light --}}
    <flux:brand class="max-lg:hidden dark:hidden" wire:navigate href="/" logo="{{ $app_settings['brand_logo'] }}"
        name="{{ $app_settings['brand_name'] }}" />

    {{-- Brand Dark --}}
    <flux:brand class="max-lg:hidden! hidden dark:flex" href="/" logo="{{ $app_settings['brand_logo_dark'] }}"
        name="{{ $app_settings['brand_name'] }}" />

    <flux:spacer />

    {{-- Navbar --}}
    <flux:navbar class="max-lg:hidden">
        <flux:dropdown x-data align="end">
            <flux:button class="group" variant="subtle" square aria-label="Preferred color scheme">
                <flux:icon.sun class="text-zinc-500 dark:text-white" x-show="$flux.appearance === 'light'"
                    variant="mini" />
                <flux:icon.moon class="text-zinc-500 dark:text-white" x-show="$flux.appearance === 'dark'"
                    variant="mini" />
                <flux:icon.moon x-show="$flux.appearance === 'system' && $flux.dark" variant="mini" />
                <flux:icon.sun x-show="$flux.appearance === 'system' && ! $flux.dark" variant="mini" />
            </flux:button>

            <flux:menu>
                <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Light</flux:menu.item>
                <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Dark</flux:menu.item>
                <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">System
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:navbar>
</flux:header>

{{-- Mobile Sidebar --}}
<flux:sidebar class="border-r border-zinc-200 bg-zinc-50 lg:hidden dark:border-zinc-700 dark:bg-zinc-900" sticky
    collapsible="mobile">
    <flux:sidebar.header>
        <flux:sidebar.brand wire:navigate href="#" logo="{{ $app_settings['brand_logo'] }}"
            logo:dark="{{ $app_settings['brand_logo_dark'] }}" name="{{ $app_settings['brand_name'] }}" />
        <flux:sidebar.collapse
            class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
    </flux:sidebar.header>
    <flux:sidebar.spacer />
    <flux:sidebar.nav>
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun" />
            <flux:radio value="dark" icon="moon" />
            <flux:radio value="system" icon="computer-desktop" />
        </flux:radio.group>
    </flux:sidebar.nav>
</flux:sidebar>
