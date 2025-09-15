<a href="{{ $target }}"
    {{ $attributes->merge([
        'class' => 'bg-secondary-400 font-semibold text-white px-1 py-1 w-full hover:bg-secondary-500',
    ]) }}>
    {{ $slot }}
</a>
