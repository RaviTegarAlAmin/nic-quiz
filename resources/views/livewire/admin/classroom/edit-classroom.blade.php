<div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <div class="md:col-span-2 flex">
            <div><x-label for="name" class="mr-3">Nama</x-label></div>
            <div class="flex-1">
                <x-form-input name="name" type="text" id="name" wire:model.blur="name"
                    value="{{ $name }}"/>
            </div>
        </div>


        <div class=" flex">
            <div><x-label for='capacity' class=" mr-3">Kapasitas</x-label></div>
            <div class="flex-1">
                <x-form-input name="capacity" type="text" id="capacity" wire:model.blur="capacity"
                    value="{{ $capacity }}" />
            </div>
        </div>


        <div class="flex">
            <div><x-label for="grade" class="mr-3">Tingkat</x-label></div>
            <div class="flex-1">
                <select wire:model.blur="grade" id="grade"
                    class="w-full border border-slate-400 focus:border-primary-100 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-sm text-sm font-normal py-1 px-2 focus:outline-none">
                    <option class=" bg-gray-300" value="{{ $grade }}" >{{ $grade }}</option>
                    @for ($i = 7; $i <= 9; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            @error('grade')
                <div class=" text-danger-500 text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <x-submit-button class=" col-span-4" wire:click="editClassroom">Edit Kelas</x-submit-button>

    </div>
</div>
