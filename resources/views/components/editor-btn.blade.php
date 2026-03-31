@props([
    'tooltip' => '',
    'active'  => false,
])

<button
    type="button"
    title="{{ $tooltip }}"
    :class="({{ is_bool($active) ? ($active ? 'true' : 'false') : $active }}) ? 'bg-primary-100 text-primary-700' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-700'"
    class="inline-flex items-center justify-center w-7 h-7 rounded transition-colors duration-100"
    {{ $attributes->except(['tooltip', 'active']) }}
>
    {{ $slot }}
</button>
