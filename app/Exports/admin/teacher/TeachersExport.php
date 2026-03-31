<?php

namespace App\Exports\admin\teacher;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Protection;

class TeachersExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    use Exportable;

    public function collection()
    {
        $teachers = Teacher::orderBy('name')->get();

        if ($teachers->isEmpty()) {
            return collect([
                (object) [
                    'name' => 'Masukkan Data Guru...',
                    'nip' => '...',
                    'gender' => '...',
                    'born_date' => '2000-01-01',
                    'address' => '...',
                ],
            ]);
        }

        return $teachers;
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function map($teacher): array
    {
        return [
            $teacher->name,
            $teacher->nip,
            $teacher->gender,
            $teacher->born_date,
            $teacher->address,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIP',
            'Gender',
            'Tanggal Lahir',
            'Alamat',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->setCellValue('A1', 'Data');
                $sheet->setCellValue('B1', 'Guru');

                $lastRow = $sheet->getHighestRow();
                $lastCol = $sheet->getHighestColumn();

                $tableRange = "A4:{$lastCol}{$lastRow}";
                $headerRange = "A4:{$lastCol}4";
                $ttlRange = "D5:D{$lastRow}";
                $addressRange = "E5:E{$lastRow}";
                $otherRange = "A5:D{$lastRow}";
                $nameRange = "A5:A{$lastRow}";
                $metaRange = 'A1:B1';

                $sheet->getStyle($tableRange)->applyFromArray([
                    'font' => [
                        'name' => 'Times New Roman',
                        'size' => 12,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getStyle($metaRange)->applyFromArray([
                    'font' => [
                        'name' => 'Times New Roman',
                        'size' => 12,
                    ],
                ]);

                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '9DB7D5',
                        ],
                    ],
                    'protection' => [
                        'locked' => Protection::PROTECTION_PROTECTED,
                    ],
                ]);

                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '9DB7D5',
                        ],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    'protection' => [
                        'locked' => Protection::PROTECTION_PROTECTED,
                    ],
                ]);

                $sheet->getStyle('B1')->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getStyle("A2:{$lastCol}1000")->applyFromArray([
                    'protection' => [
                        'locked' => Protection::PROTECTION_UNPROTECTED,
                    ],
                ]);

                $sheet->getStyle($ttlRange)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle($addressRange)->applyFromArray([
                    'alignment' => [
                        'wrapText' => true,
                        'vertical' => Alignment::VERTICAL_TOP,
                    ],
                ]);

                $sheet->getStyle($otherRange)->applyFromArray([
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $sheet->getStyle($nameRange)->applyFromArray([
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                ]);

                $sheet->getColumnDimension('E')->setWidth(50);
                $sheet->freezePane('A5');
                $sheet->getProtection()->setSheet(true)->setPassword('mtsnic');
                $sheet->setTitle('Guru');
            },
        ];
    }
}
