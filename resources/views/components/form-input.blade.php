<div class=" mb-4">
    <input
        class="w-full border border-slate-400 focus:border-primary-100 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-sm text-sm font-normal py-1 px-2 focus:outline-none"
        type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}">

    @error($name)
        <div class=" text-danger-500 text-sm">
            {{ $message }}
        </div>
    @enderror
</div>
