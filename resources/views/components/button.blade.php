@props([
    'type' => 'button',
    'variant' => 'primary',
])

@php

    $baseClasses = 'w-32 text-center font-semibold rounded-xl px-3 py-1 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2';

    $variantClasses = match ($variant) {
        'success' => 'bg-success-500 text-white border border-success-600 hover:bg-success-600 focus:ring-success-400 border-b-4 border-b-success-600 hover:border-b-transparent',
        'danger' => 'bg-danger-500 text-white border border-danger-600 hover:bg-danger-600 focus:ring-danger-400 border-b-4 border-b-danger-600 hover:border-b-transparent',
        'warning' => 'bg-warning-500 text-white border border-warning-600 hover:bg-warning-600 focus:ring-warning-400 border-b-4 border-b-warning-600 hover:border-b-transparent',
        'secondary' => 'bg-secondary-400 text-white border border-secondary-600 hover:bg-secondary-600 focus:ring-secondary-400 border-b-4 border-b-secondary-600 hover:border-b-transparent',
        'outline' => 'text-secondary-400 border border-secondary-400 hover:bg-secondary-100 focus:ring-secondary-400',
        default => 'bg-primary-500 text-white border border-primary-600 hover:bg-primary-600 focus:ring-primary-400 border-b-4 border-b-primary-600 hover:border-b-transparent',
    };
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->class("$baseClasses $variantClasses") }}
>
    {{ $slot }}
</button>
