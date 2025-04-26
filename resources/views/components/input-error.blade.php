@props([
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
    'messages' => [],
])

@if (!empty($messages) && is_array($messages))
    <ul {{ $attributes->merge(['class' => 'text-sm text-error font-medium space-y-1']) }}>
        @foreach ($messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
