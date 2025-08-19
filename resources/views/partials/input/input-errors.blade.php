<div class="flex flex-col pt-1 pl-2 w-full">
    @foreach ($errors->get($field) as $error)
        <span class="text-red-500 font-semibold text-sm">{{ $error }}</span>
    @endforeach
</div>
