@props([
    'type' => 'submit'
])

<button
{{ $attributes->merge([
    'type' => $type,
    'class' => " bg-secondary-400 font-semibold text-white px-1 py-1 w-full hover:bg-secondary-500"
])
}}>{{ $slot }}</button>
