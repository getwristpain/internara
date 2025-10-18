<div x-data="{
    isUploading: false,
    progress: 0,
    isDragging: false,
    files: @entangle('files').live,

    handleDrop(e) {
        this.isDragging = false;
        this.$refs.fileInput.files = e.dataTransfer.files;
        this.$refs.fileInput.dispatchEvent(new Event('change'));
    },
}" x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress">

    {{-- 1. HEADER & LABEL --}}
    <label class="mb-2 block text-sm font-medium text-neutral-800 dark:text-neutral-200">
        {{ $label }}

        @if (!empty($hint))
            <span class="ml-2 text-xs text-neutral-500 dark:text-neutral-400">
                ({{ $hint }})
            </span>
        @endif
    </label>

    {{-- 2. CUSTOM FILE INPUT & DRAG AND DROP AREA --}}
    <div class="{{ $multiple ? 'border-neutral-300 dark:border-neutral-700 hover:border-neutral-500 dark:hover:border-neutral-500' : 'min-h-[150px] h-full flex items-center justify-center group' }} relative cursor-pointer rounded-lg border-4 border-dashed p-4 transition-all duration-300"
        @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)"
        x-data="{ isHovering: false }" x-on:mouseenter="isHovering = true" x-on:mouseleave="isHovering = false"
        :class="{
            'bg-neutral-100 dark:bg-neutral-800 border-neutral-600 dark:border-neutral-400': isDragging,
        
            // Kondisi 1: Placeholder/Empty State (hanya muncul jika NOT isDragging, NOT files, dan NOT existing media)
            'border-neutral-200 dark:border-neutral-700 hover:border-neutral-300 dark:hover:border-neutral-600': !
                isDragging && (!files.length && !(
                    {{ $multiple ? 'false' : ($existingMedia->isNotEmpty() ? 'true' : 'false') }})),
        
            // Kondisi 2: Preview State (jika ada files atau existing media. Dievaluasi di PHP)
            'border-neutral-400/50 bg-neutral-100/50 dark:border-neutral-600/50 dark:bg-neutral-800/50 hover:border-neutral-600 dark:hover:border-neutral-500': files
                .length > 0 || {{ $multiple ? 'false' : ($existingMedia->isNotEmpty() ? 'true' : 'false') }}
        }"
        x-on:click="$refs.fileInput.click()">

        <input class="sr-only" id="file-uploader-{{ $model->id ?? 'new' }}" x-ref="fileInput" type="file"
            wire:model.live="files" @if ($multiple) multiple @endif>

        @php
            $displayFile = $files[0] ?? $existingMedia->first();
            $isTemporary = isset($files[0]);
        @endphp

        @if (!$multiple && $displayFile)
            {{-- SINGLE MODE: ACTIVE PREVIEW (NEW OR EXISTING FILE) --}}
            @php
                // === KOREKSI LOGIKA EKSTENSI DAN UKURAN UNTUK MENGHINDARI BadMethodCallException ===
                if ($isTemporary) {
                    $extension = strtoupper($displayFile->getClientOriginalExtension() ?? 'FILE');
                    $size = $displayFile->getSize();
                    $fileName = $displayFile->getClientOriginalName();
                } else {
                    // $displayFile adalah objek Spatie\MediaLibrary\MediaCollections\Models\Media
                    $extension = strtoupper(pathinfo($displayFile->file_name, PATHINFO_EXTENSION) ?? 'FILE');
                    $size = $displayFile->size;
                    $fileName = $displayFile->file_name;
                }

                $sizeKB = round($size / 1024, 2);
                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            @endphp

            <div class="absolute inset-0 flex flex-col items-center justify-center space-y-2 overflow-hidden p-2">

                {{-- Drag-Over Overlay (Blue for UX feedback) --}}
                <div class="pointer-events-auto absolute inset-0 z-20 flex flex-col items-center justify-center rounded-lg bg-blue-600/90 p-3 text-white shadow-xl"
                    x-show="isDragging" x-transition:enter.opacity.duration.150ms
                    x-transition:leave.opacity.duration.150ms>

                    <svg class="mx-auto h-16 w-16 animate-bounce text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v8" />
                    </svg>
                    <p class="mt-4 text-xl font-bold uppercase">LEPAS UNTUK MENGGANTI</p>
                    <p class="text-sm">({{ $fileName }}) akan
                        diganti</p>
                </div>

                @if ($isImage)
                    {{-- Image Preview --}}
                    <div class="pointer-events-none relative flex h-full w-full items-center justify-center p-2">
                        @if ($isTemporary)
                            <img class="max-h-full max-w-full rounded-lg object-contain"
                                src="{{ $displayFile->temporaryUrl() }}" alt="File Preview">
                        @else
                            <img class="max-h-full max-w-full rounded-lg object-contain"
                                src="{{ $displayFile->getUrl() }}" alt="File Existing">
                        @endif
                    </div>

                    {{-- Info & Action Button (Replace/Delete) --}}
                    <div class="pointer-events-none absolute bottom-0 left-0 right-0 z-10 border-t border-neutral-200 bg-white/80 p-1 text-center backdrop-blur-sm transition-opacity duration-300 dark:border-neutral-700 dark:bg-neutral-900/80"
                        :class="{ 'opacity-0 group-hover:opacity-100 pointer-events-auto': !isHovering }">
                        <p class="truncate text-xs font-medium text-neutral-700 dark:text-neutral-300"
                            title="{{ $fileName }}">
                            {{ $fileName }}
                            <span class="text-neutral-500 dark:text-neutral-400">({{ $extension }},
                                {{ $sizeKB }} KB)</span>
                        </p>
                        @if ($isTemporary)
                            <button
                                class="text-xs text-red-600 transition hover:text-red-800 dark:text-red-500 dark:hover:text-red-400"
                                type="button" wire:click.stop="removeFile(0)" title="Ganti File">
                                Klik untuk Ubah Berkas
                            </button>
                        @else
                            <button
                                class="text-xs text-red-600 transition hover:text-red-800 dark:text-red-500 dark:hover:text-red-400"
                                type="button" wire:click.stop="removeExistingMedia({{ $displayFile->id }})"
                                title="Hapus File Permanen">
                                Klik untuk Hapus Berkas
                            </button>
                        @endif
                    </div>
                @else
                    {{-- Non-Image Icon --}}
                    <div class="pointer-events-none flex flex-col items-center justify-center space-y-2">
                        <div
                            class="flex h-16 w-16 items-center justify-center rounded-full border border-dashed border-neutral-400 bg-neutral-200 text-sm font-bold uppercase text-neutral-600 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-300">
                            {{ $extension }}
                        </div>
                        <p class="max-w-[90%] truncate text-center text-sm font-medium text-neutral-700 dark:text-neutral-300"
                            title="{{ $fileName }}">
                            {{ $fileName }}
                        </p>
                        <p class="mt-0.5 text-xs text-neutral-500 dark:text-neutral-400">({{ $sizeKB }} KB)</p>

                        @if ($isTemporary)
                            <button
                                class="mt-1 text-xs text-red-600 transition hover:text-red-800 dark:text-red-500 dark:hover:text-red-400"
                                type="button" wire:click.stop="removeFile(0)"
                                :class="{ 'opacity-0 group-hover:opacity-100 pointer-events-auto': !isHovering }">
                                Klik untuk Ubah Berkas
                            </button>
                        @else
                            <button
                                class="mt-1 text-xs text-red-600 transition hover:text-red-800 dark:text-red-500 dark:hover:text-red-400"
                                type="button" wire:click.stop="removeExistingMedia({{ $displayFile->id }})"
                                :class="{ 'opacity-0 group-hover:opacity-100 pointer-events-auto': !isHovering }">
                                Klik untuk Hapus Berkas
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        @else
            {{-- DRAG & DROP PLACEHOLDER --}}
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-neutral-400 dark:text-neutral-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v8" />
                </svg>
                <p class="mt-1 text-sm font-medium text-neutral-600 dark:text-neutral-300"
                    x-text="isDragging ? 'LEPAS BERKAS DI SINI' : 'Tarik dan lepas berkas di sini'"></p>
                <p class="text-xs text-neutral-500 dark:text-neutral-400">atau klik untuk memilih berkas</p>
            </div>
        @endif
    </div>

    {{-- 3. PROGRESS BAR --}}
    <div class="mt-2" x-show="isUploading">
        <label class="mb-1 block text-xs font-medium text-neutral-700 dark:text-neutral-300">Mengunggah...</label>
        <progress
            class="h-2 w-full overflow-hidden rounded-full bg-neutral-200 transition-all duration-300 dark:bg-neutral-700"
            max="100" x-bind:value="progress">
        </progress>
    </div>

    {{-- 4. VALIDATION ERRORS (Red) --}}
    @error('files')
        <p class="mt-1 text-sm font-medium text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
    @error('files.*')
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">Gagal memvalidasi satu atau lebih berkas:
            {{ $message }}</p>
    @enderror

    {{-- 5. MULTIPLE MODE PREVIEW LIST --}}
    @if ($multiple)
        @php
            $combinedFiles = collect($files)->merge($existingMedia);
        @endphp

        @if ($combinedFiles->isNotEmpty())
            <hr class="my-4 border-neutral-200 dark:border-neutral-700">
            <h3 class="mb-2 text-sm font-semibold text-neutral-700 dark:text-neutral-300">Pratinjau Berkas</h3>

            <div class="space-y-2">
                @foreach ($combinedFiles as $index => $file)
                    @php
                        $isTemporary = $file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

                        // === KOREKSI LOGIKA EKSTENSI DAN UKURAN ===
                        if ($isTemporary) {
                            $extension = strtoupper($file->getClientOriginalExtension() ?? 'FILE');
                            $size = $file->getSize();
                            $fileName = $file->getClientOriginalName();
                        } else {
                            $extension = strtoupper(pathinfo($file->file_name, PATHINFO_EXTENSION) ?? 'FILE');
                            $size = $file->size;
                            $fileName = $file->file_name;
                        }

                        $sizeKB = round($size / 1024, 2);
                        // ==========================================

                        $key = $isTemporary ? $index : 'media_' . $file->id;
                        $previewUrl = $isTemporary
                            ? (method_exists($file, 'temporaryUrl')
                                ? $file->temporaryUrl()
                                : '')
                            : $file->getUrl('thumb');
                    @endphp

                    <div class="flex items-center justify-between overflow-hidden rounded-lg border border-neutral-200 bg-neutral-50 p-3 shadow-sm dark:border-neutral-700 dark:bg-neutral-800"
                        wire:key="{{ $key }}">

                        <div class="flex min-w-0 flex-grow items-center space-x-4">
                            <img class="h-10 w-10 flex-shrink-0 rounded-md border border-neutral-300 object-cover dark:border-neutral-600"
                                src="{{ $previewUrl }}" alt="Pratinjau">

                            <div class="min-w-0 truncate">
                                <p class="truncate text-sm font-medium text-neutral-800 dark:text-neutral-200"
                                    title="{{ $fileName }}">
                                    {{ $fileName }}
                                </p>
                                <p class="mt-0.5 text-xs text-neutral-500 dark:text-neutral-400">{{ $extension }},
                                    {{ $sizeKB }} KB
                                </p>
                            </div>
                        </div>

                        <button
                            class="ml-4 flex-shrink-0 rounded-full p-1 text-red-600 transition hover:bg-red-100 hover:text-red-800 dark:text-red-500 dark:hover:bg-red-900 dark:hover:text-red-400"
                            type="button"
                            wire:click="{{ $isTemporary ? "removeFile($index)" : "removeExistingMedia($file->id)" }}"
                            wire:loading.attr="disabled"
                            title="{{ $isTemporary ? 'Batalkan Unggahan' : 'Hapus Berkas' }}">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.707a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 000-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>
