<?php

namespace App\Livewire\Admin\Teacher;

use App\Imports\admin\teacher\TeachersImport;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Upload extends Component
{
    use WithFileUploads;

    #[Validate([
        'excelFile' => [
            'required',
            'file',
            'mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel',
            'max:10240',
        ],
    ])]
    public $excelFile;

    public function import()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                Excel::import(new TeachersImport(), $this->excelFile->getRealPath());
            });

            $this->reset('excelFile');

            $this->dispatch('close-teacher-upload');
            $this->dispatch('refresh-teacher-table');
            $this->dispatch('show-toast', [
                'message' => 'File guru berhasil diupload',
                'type' => 'success',
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('show-toast', [
                'message' => 'File guru gagal diupload',
                'type' => 'failed',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.teacher.upload');
    }
}
