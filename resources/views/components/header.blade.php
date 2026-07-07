@props([
    'variant' => 'default',
])

@php
    [$padding, $margin, $textSize, $barHeight] = match ($variant) {
        'thin' => ['px-5 py-3', 'mb-3', 'text-lg', 'h-6'],
        'extrathin' => ['px-4 py-2', 'mb-2', 'text-base', 'h-5'],
        default => ['px-6 py-5', 'mb-6', 'text-xl', 'h-7'],
    };
@endphp

<div {{ $attributes->class([
    'flex items-center gap-3',
    'border-2 rounded-xl bg-secondary-400/80',
    $padding,
    $margin,
]) }}
    style="border-color: #3C3489; box-shadow: 4px 4px 0 #3C3489;">
    <div class="w-1 {{ $barHeight }} rounded-sm" style="background-color: #FAC775;"></div>

    <h1 class="{{ $textSize }} font-semibold" style="color: #EEEDFE;">
        {{ $slot }}
    </h1>
</div>
