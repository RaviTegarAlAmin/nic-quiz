@props(['name', 'type', 'placeholder', 'value'])

<div class=" mb-4">
    <input
        {{ $attributes->merge([
            'class' =>
                'w-full border border-slate-400 focus:border-primary-100 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-sm text-sm font-normal py-1 px-2 focus:outline-none',
        ]) }}
        type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}" value="{{$value}}">

    @error($name)
        <div class=" text-danger-500 text-sm">
            {{ $message }}
        </div>
    @enderror
</div>
