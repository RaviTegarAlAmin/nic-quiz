@props([
    'label' => '',
    'name',
])

<div class="relative w-full">
    <select id="{{ $name }}" name="{{ $name }}"
        {{ $attributes->merge([
            'class' =>
                'peer w-full rounded-sm text-sm font-normal
                                 pt-5 pb-1 px-2 transition
                                 border border-secondary-100
                                 ring-1 ring-transparent
                                 shadow-sm hover:shadow-md focus:shadow-md
                                 focus:outline-none focus:border-secondary-400 focus:ring-secondary-200
                                 ' . ($errors->has($name) ? 'border-danger-500 ring-danger-300' : ''),
        ]) }}>
        {{ $slot }}
    </select>

    <label for="{{ $name }}"
        class="absolute left-2 bg-white px-1 text-gray-500 transition-all pointer-events-none
           top-2
           peer-placeholder-shown:top-3
           peer-placeholder-shown:text-sm
           peer-focus:-top-2
           peer-focus:text-xs
           peer-[&:not(:placeholder-shown)]:-top-2
           peer-[&:not(:placeholder-shown)]:text-xs
           peer-focus:text-secondary-500
           peer-[&:not(:placeholder-shown)]:text-secondary-500">
        {{ $label }}
    </label>

    @error($name)
        <div class="mt-1 text-danger-500 text-sm">
            {{ $message }}
        </div>
    @enderror
</div>
