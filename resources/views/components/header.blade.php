<div
    {{ $attributes->class([
        'flex items-center gap-3',
        'border-2 rounded-xl px-6 py-5 mb-6 bg-secondary-400/80',
    ]) }}
    style=" border-color: #3C3489; box-shadow: 4px 4px 0 #3C3489;">
    <div class="w-1 h-7 rounded-sm" style="background-color: #FAC775;"></div>
    <h1 class="text-xl font-semibold" style="color: #EEEDFE;">{{ $slot }}</h1>
</div>
