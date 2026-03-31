<?php

namespace App\Imports\admin\teacher;

use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TeachersImport implements ToCollection, WithHeadingRow
{
    public function headingRow(): int
    {
        return 4;
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $nip = trim((string) ($row['nip'] ?? ''));
            $name = trim((string) ($row['nama'] ?? ''));
            $gender = trim((string) ($row['gender'] ?? ''));
            $bornDate = $row['tanggal_lahir'] ?? null;
            $address = trim((string) ($row['alamat'] ?? ''));

            if ($nip === '' || $nip === '...') {
                continue;
            }

            $user = User::firstOrCreate(
                ['email' => strtolower($nip) . '@mtsnic.com'],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                ]
            );

            if ($user->name !== $name) {
                $user->update(['name' => $name]);
            }

            Teacher::updateOrCreate(
                ['nip' => $nip],
                [
                    'user_id' => $user->id,
                    'name' => $name,
                    'gender' => $gender,
                    'born_date' => $this->transformDate($bornDate),
                    'address' => $address,
                ]
            );
        }
    }

    private function transformDate(mixed $bornDate): string
    {
        if ($bornDate === null) {
            return Carbon::create(2000, 1, 1)->toDateString();
        }

        if (is_numeric($bornDate)) {
            return Carbon::instance(Date::excelToDateTimeObject($bornDate))->toDateString();
        }

        $bornDate = trim((string) $bornDate);

        if ($bornDate === '' || $bornDate === '...') {
            return Carbon::create(2000, 1, 1)->toDateString();
        }

        return Carbon::parse($bornDate)->toDateString();
    }
}
