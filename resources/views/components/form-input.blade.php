@props(['name', 'type', 'placeholder', 'value'])

<div class=" mb-4">
    @if ($type == 'textarea')
        <textarea
            {{ $attributes->merge([
                'class' =>
                    'w-full h-full border border-primary-100 ring-1 ring-slate-300 focus:border-primary-400 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-md text-sm font-normal py-1 px-2  resize-none',
            ]) }}
            name="{{ $name }}" id="{{ $name }}" cols="{{$col ?? 30}}" rows="{{$row ?? 5}}"></textarea>
    @else
        <input
            {{ $attributes->merge([
                'class' =>
                    'w-full border border-primary-100 ring-1 ring-slate-300 focus:border-primary-400 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-sm text-sm font-normal py-1 px-2 ',
            ]) }}
            type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}"
            value="{{ $value }}">

        @error($name)
            <div class=" text-danger-500 text-sm">
                {{ $message }}
            </div>
        @enderror
    @endif
</div>
