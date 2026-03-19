<div class=" grid md:grid-cols-6 gap-3 grid-cols-3">


    {{-- Student's Biodata --}}



    <div class=" col-span-3">
        <x-form wire:model.blur="name" :label="'Name'" :name="'name'" :type="'text'" :value="$name"
            class=" col-span-3"></x-form>
    </div>

    <div>
        <x-floating-select :label="'Jenis Kelamin'" :name="'gender'" wire:model.blur="gender">
            <option value="" selected disabled hidden></option>
            <option value="Laki-Laki">Laki-Laki</option>
            <option value="Perempuan">Perempuan</option>
        </x-floating-select>
    </div>

    <div class=" col-span-2 ">
        <x-form :label="'Tanggal Lahir'" name="born_date" type="date" wire:model.blur="born_date"></x-form>
    </div>

    <div class=" col-span-6">
        <x-form :label="'Alamat'" name="address" wire:model.blur="address"></x-form>
    </div>

    {{-- Button --}}

    <div class=" col-span-5">
        <x-button wire:click="updateStudent" class=" w-full" variant="secondary">Ubah Data Siswa</x-button>
    </div>

    <div>
        <x-button wire:click="resetForm" variant="danger">Reset</x-button>
    </div>



</div>
