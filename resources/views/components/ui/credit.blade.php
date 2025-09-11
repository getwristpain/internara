@props([
    'app_name' => config('app.name'),
    'author' => config('app.author'),
    'publisher' => config('app.publisher', 'Hak cipta dilindungi undang-undang.'),
    'year' => date('Y'),
    'docs_url' => config('app.docs'),
])

<div class="w-full text-center text-xs md:text-sm text-gray-500 font-medium">
    <span><b>{{ $app_name }}</b> &copy {{ $year }} | Dikembangkan oleh <a class="font-bold"
            href="{{ $docs_url }}">{{ $author }} ({{ ucfirst($publisher) }})</a></span>
</div>
