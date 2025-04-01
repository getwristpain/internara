@props(['departments' => []])

<div class="space-y-8">
    <div class="p-4 bg-gray-100 border rounded-xl">
        <x-form name="department-form" submit="addDepartment">
            <div class="flex w-full gap-4">
                <x-forms.input-text required type="text" model="new_department.name"
                    placeholder="Masukkan nama jurusan baru..." hideMessages />
                <button class="btn btn-neutral" type="submit">Tambah</button>
            </div>
            @if (!empty($new_department['code']))
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2 text-sm font-medium">
                        <span class="w-fit">+ Jurusan Baru:</span>
                        <x-forms.input-text class="max-w-28" required type="text" model="new_department.code"
                            inputClass="input-sm" />
                        <span class="divider divider-strip"></span>
                        <span class="flex-1">{{ $new_department['name'] }}</span>
                    </div>
                    <x-forms.input-error :messages="$errors->get('new_department.code')"></x-forms.input-error>
                    <x-forms.input-error :messages="$errors->get('new_department.name')"></x-forms.input-error>
                </div>
            @endif
        </x-form>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
        <div class="flex flex-col gap-8">
            @foreach (collect($departments)->filter(fn($d, $i) => $i % 2 === 0) as $department)
                <div class="flex flex-col w-full gap-4 p-4 border rounded-xl h-fit">
                    <div class="flex items-center justify-between w-full gap-2">
                        <div class="flex-1">
                            <span class="font-semibold">{{ $department['code'] }} - {{ $department['name'] }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <x-button class="btn-sm btn-ghost" action="toggleClassrooms({{ $department['id'] }})"
                                icon="icon-park-outline:down-c" iconEffect="rotate"
                                reverse>{{ collect($department['classrooms'] ?? [])->count() }}
                                Kelas</x-button>
                            <x-button class="btn-error btn-outline btn-circle btn-xs" icon="mdi:trash"
                                action="deleteDepartment({{ $department['id'] }})" hideLabel></x-button>
                        </div>
                    </div>
                    <div class="flex-col gap-2 {{ $showClassrooms[$department['id']] ?? false ? 'flex' : 'hidden' }}">
                        @foreach ($department['classrooms'] as $classroom)
                            <div
                                class="flex items-center justify-between w-full px-4 py-2 border rounded-xl basic-transition hover:bg-gray-100">
                                <span class="text-sm font-medium">
                                    {{ implode(' ', [$classroom['level'], $department['code'], $classroom['name']]) }}
                                </span>
                                <x-button class="btn-error btn-outline btn-circle btn-xs" icon="mdi:trash"
                                    action="deleteClassroom({{ $classroom['id'] }})" hideLabel></x-button>
                            </div>
                        @endforeach
                        <div class="w-full overflow-hidden border border-gray-300 border-dashed rounded-xl">
                            <x-button class="w-full text-gray-600 btn-sm" icon="stash:plus-solid"
                                action="openClassroomModal('{{ $department['code'] }}')">Tambah Kelas</x-button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex flex-col gap-8">
            @foreach (collect($departments)->filter(fn($d, $i) => $i % 2 !== 0) as $department)
                <div class="flex flex-col w-full border rounded-xl h-fit">
                    <div
                        class="flex items-center justify-between w-full gap-2 p-4 rounded-xl basic-transition hover:bg-gray-100">
                        <div class="flex-1">
                            <span class="font-semibold">{{ $department['code'] }} - {{ $department['name'] }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <x-button class="btn-sm btn-ghost" action="toggleClassrooms({{ $department['id'] }})"
                                icon="icon-park-outline:down-c" iconEffect="rotate"
                                reverse>{{ collect($department['classrooms'] ?? [])->count() }}
                                Kelas</x-button>
                            <x-button class="btn-error btn-outline btn-circle btn-xs" icon="mdi:trash"
                                action="deleteDepartment({{ $department['id'] }})" hideLabel></x-button>
                        </div>
                    </div>
                    <div
                        class="flex-col gap-2 p-4 {{ $showClassrooms[$department['id']] ?? false ? 'flex' : 'hidden' }}">
                        @foreach ($department['classrooms'] as $classroom)
                            <div
                                class="flex items-center justify-between w-full px-4 py-2 border rounded-xl basic-transition hover:bg-gray-100">
                                <span class="text-sm font-medium">
                                    {{ implode(' ', [$classroom['level'], $department['code'], $classroom['name']]) }}
                                </span>
                                <x-button class="btn-error btn-outline btn-circle btn-xs" icon="mdi:trash"
                                    action="deleteClassroom({{ $classroom['id'] }})" hideLabel></x-button>
                            </div>
                        @endforeach
                        <div class="w-full overflow-hidden border border-gray-300 border-dashed rounded-xl">
                            <x-button class="w-full text-gray-600 btn-sm" icon="stash:plus-solid"
                                action="openClassroomModal('{{ $department['code'] }}')">Tambah Kelas</x-button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @empty($departments)
            <div class="w-full col-span-2 p-4 border rounded-xl">
                <p class="text-center">Belum ada jurusan yang ditambahkan.</p>
            </div>
        @endempty
    </div>

    <x-modal name="classroom_modal" show="showClassroomModal">
        <x-slot name="header">
            @if (!empty($new_classroom['department_code']))
                <span>Tambah Kelas ({{ $new_classroom['department_code'] }})</span>
            @else
                <span>Tambah Kelas</span>
            @endif
        </x-slot>
        <x-slot name="body">
            <x-form name="classroom-form" submit="addClassroom">
                <div class="flex flex-col items-center gap-4 md:flex-row">
                    <x-forms.input-select class="md:w-1/4" required name="classroom_level" model="new_classroom.level"
                        options="classroomLevelOptions" placeholder="Pilih Tingkatan" />
                    <x-forms.input-text required name="classroom_name" model="new_classroom.name"
                        placeholder="Nama kelas baru..." />
                </div>
                @if (!empty($new_classroom['code']))
                    <div>
                        <div class="text-sm text-gray-500">
                            <span class="font-semibold">+ Kelas Baru: </span>{{ $new_classroom['code'] }}
                        </div>

                        <x-forms.input-error :messages="$errors->get('new_classroom.code')" />
                    </div>
                @endif
            </x-form>
        </x-slot>
        <x-slot name="footer">
            <x-button class="btn-ghost" action="closeClassroomModal">Batal</x-button>
            <x-forms.submit form="classroom-form" hideIcon>
                Tambah
            </x-forms.submit>
        </x-slot>
    </x-modal>
</div>
