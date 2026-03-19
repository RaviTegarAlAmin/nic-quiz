@props([
    'label' => '',
    'name',
    'type' => 'text',
    'value' => '',
])

<div class="relative w-full">
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value }}"
        placeholder=" "
        {{ $attributes->merge([
            'class' =>
                'peer w-full rounded-sm text-sm font-normal
                                         pt-5 pb-1 px-2 transition
                                         border border-secondary-100
                                         ring-1 ring-transparent
                                         shadow-sm hover:shadow-md
                                         focus:outline-none focus:border-secondary-400
                                         ' . ($errors->has($name) ? 'border-danger-500 ring-danger-300' : ''),
        ]) }} />

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
