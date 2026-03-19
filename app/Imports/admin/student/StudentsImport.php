<?php

namespace App\Imports\admin\student;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\BeforeSheet;

class StudentsImport implements ToCollection, WithHeadingRow, WithEvents
{
    private ?int $classroomId = null;

    public function headingRow(): int
    {
        return 4;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $classroomName = trim((string) $event->sheet->getDelegate()->getCell('B1')->getValue());

                $this->classroomId = Classroom::where('name', $classroomName)->value('id');

                if (! $this->classroomId) {
                    throw new \RuntimeException('Classroom tidak ditemukan pada file import.');
                }
            },
        ];
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $nis = trim((string) ($row['nis'] ?? ''));
            $name = trim((string) ($row['nama'] ?? ''));
            $gender = trim((string) ($row['gender'] ?? ''));
            $address = trim((string) ($row['alamat'] ?? ''));

            if ($nis === '' || $nis === '...') {
                continue;
            }

            $user = User::firstOrCreate(
                ['email' => strtolower($nis) . '@mtsnic.com'],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                ]
            );

            if ($user->name !== $name) {
                $user->update(['name' => $name]);
            }

            $existingStudent = Student::where('nis', $nis)->first();

            Student::updateOrCreate(
                ['nis' => $nis],
                [
                    'classroom_id' => $this->classroomId,
                    'name' => $name,
                    'gender' => $gender,
                    'born_date' => $existingStudent?->born_date ?? Carbon::create(2000, 1, 1)->toDateString(),
                    'address' => $address,
                    'user_id' => $user->id,
                ]
            );
        }
    }
}
