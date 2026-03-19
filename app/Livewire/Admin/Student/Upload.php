<?php

namespace App\Livewire\Admin\Student;

use App\Imports\admin\student\StudentsImport;
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
        ]
    ])]
    public $excelFile;

    public function import()
    {

        $this->validate();

        try {

            DB::transaction(function () {
                Excel::import(new StudentsImport(), $this->excelFile->getRealPath());
            });

            $this->reset('excelFile');

            $this->dispatch('close-upload-modal');

            $this->dispatch('refresh-table');

            $this->dispatch('show-toast', [
                'message' => 'File Berhasil Diupload',
                'type' => 'success'
            ]);

        } catch (\Throwable $th) {

            $this->dispatch('show-toast', [
                'message' => 'File Gagal Diupload',
                'type' => 'failed'
            ]);

        }

    }

    public function render()
    {
        return view('livewire.admin.student.upload');
    }
}
