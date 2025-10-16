<x-card :$size :$bordered wire:init="initialize()">
    <x-card.header size="xl" :$title :$description />

    <form class="grid grid-cols-2 gap-6" wire:submit="save">
        <flux:input wire:model="data.name" type="text" label="Nama sekolah" placeholder="Nama sekolah" required autofocus
            autocomplete="school_name" icon="building-office" :icon:trailing="$readyToLoad ? null : 'loading'" />

        <flux:input wire:model="data.principal_name" type="text" label="Nama kepala sekolah"
            placeholder="Nama kepala sekolah" required autocomplete="school_principal_name" icon="user"
            :icon:trailing="$readyToLoad ? null : 'loading'" />

        <div class="col-span-full">
            <flux:textarea wire:model="data.address" label="Alamat sekolah" placeholder="Alamat sekolah" required
                autocomplete="school_address" rows="3" :icon:trailing="$readyToLoad ? null : 'loading'" />
        </div>

        <div class="col-span-full">
            <flux:input wire:model="data.postal_code" type="number" label="Kode Pos" placeholder="xxxxxx" required
                autocomplete="school_postal_code" />
        </div>

        <flux:input wire:model="data.phone" type="tel" label="Telp. sekolah" placeholder="xx xxxx xxxx" required
            autocomplete="school_phone" icon="phone" :icon:trailing="$readyToLoad ? null : 'loading'" />

        <flux:input wire:model="data.fax" type="tel" label="Fax. sekolah" placeholder="xxx xxxx xxxx" required
            autocomplete="school_fax" icon="phone" :icon:trailing="$readyToLoad ? null : 'loading'" />

        <flux:input wire:model="data.email" type="text" label="Email sekolah" placeholder="Email sekolah" required
            autocomplete="school_email" icon="envelope" :icon:trailing="$readyToLoad ? null : 'loading'" />

        <flux:input wire:model="data.website" type="text" label="Website sekolah"
            placeholder="https://example.sch.id" required autocomplete="school_website" icon="globe-alt"
            :icon:trailing="$readyToLoad ? null : 'loading'" />

        <flux:button class="col-span-full w-full" type="submit" variant="primary">Simpan</flux:button>
    </form>
</x-card>
