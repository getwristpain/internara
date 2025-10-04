@props([
    'attributes' => null,
    'size' => 'lg',
    'bordered' => false,
    'class' => '',
])

@php
    $sizeClass = match ($size) {
        'xl' => 'w-full max-w-xl rounded-2xl',
        'lg' => 'w-full max-w-lg rounded-xl',
        'md' => 'w-full max-w-md rounded-lg',
        'sm' => 'w-full max-w-sm rounded-md',
        'xs' => 'w-full max-w-xs rounded-sm',
        'fit' => 'w-fit',
        'full' => 'w-full rounded-2xl',
        'screen' => 'w-full h-full container mx-auto rounded-2xl',
    };

    $class = css($class, $sizeClass, 'flex flex-col gap-6 p-6 min-w-xs transition duration-150 ease-in-out', [
        'border-2 border-neutral-200 dark:border-neutral-800 shadow-xs shadow-neutral-200 dark:shadow-neutral-800 hover:shadow-lg' => $bordered,
    ]);
@endphp

<div class="{{ $class }}" {{ $attributes }}>
    {{ $slot }}
</div>
