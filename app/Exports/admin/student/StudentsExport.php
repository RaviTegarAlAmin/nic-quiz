<?php

namespace App\Exports\admin\student;

use App\Models\Classroom;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;


class StudentsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     * @param  Student $student
     */





    public function __construct(public int $classroomId)
    {
        $this->classroomId = $classroomId;
    }

    public function collection()
    {
        $students = Student::where('classroom_id', $this->classroomId)->get();

        if ($students->isEmpty()) {
            return collect([
                (object) [
                    'name' => 'Masukkan Data Siswa...',
                    'nis' => '...',
                    'gender' => '...',
                    'address' => '...',
                ]
            ]);
        }

        return $students;

    }

    public function startCell(): string
    {
        return 'A4';
    }



    public function map($student): array
    {

        return [
            $student->name,
            $student->nis,
            $student->gender,
            $student->address
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIS',
            'Gender',
            'Alamat'
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $classroomName = Classroom::find($this->classroomId)?->name ?? '-';

                $sheet->setCellValue('A1', 'Classroom');
                $sheet->setCellValue('B1', $classroomName);

                $lastRow = $sheet->getHighestRow();
                $lastCol = $sheet->getHighestColumn();

                $tableRange = "A4:{$lastCol}{$lastRow}";
                $headerRange = "A4:{$lastCol}4";
                $bodyRange = "A5:{$lastCol}{$lastRow}";
                $addressRange = "D5:D{$lastRow}";
                $otherRange = "A5:C{$lastRow}";
                $nameRange = "A5:A{$lastRow}";
                $classroomLabelRange = 'A1';
                $classroomValueRange = 'B1';
                $classroomMetaRange = 'A1:B1';

                /** Font */
                $sheet->getStyle($tableRange)->applyFromArray([
                    'font' => [
                        'name' => 'Times New Roman',
                        'size' => 12,
                    ],
                ]);

                $sheet->getStyle($classroomMetaRange)->applyFromArray([
                    'font' => [
                        'name' => 'Times New Roman',
                        'size' => 12,
                    ],
                ]);

                /** Borders */
                $sheet->getStyle($tableRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                /** Header */
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

                $sheet->getStyle($classroomLabelRange)->applyFromArray([
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

                $sheet->getStyle($classroomValueRange)->applyFromArray([
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

                /** Address */
                $sheet->getStyle($addressRange)->applyFromArray([
                    'alignment' => [
                        'wrapText' => true,
                        'vertical' => Alignment::VERTICAL_TOP,
                    ],
                ]);

                /** Name, NIS, Gender */
                $sheet->getStyle($otherRange)->applyFromArray([
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'horizontal' => Alignment::HORIZONTAL_CENTER
                    ],
                ]);

                $sheet->getStyle($nameRange)->applyFromArray([
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'horizontal' => Alignment::HORIZONTAL_LEFT
                    ],
                ]);

                /** Address width */
                $sheet->getColumnDimension('D')->setWidth(50);

                /** Freeze header */
                $sheet->freezePane('A5');

                /* Protect Sheet */
                $sheet->getProtection()
                    ->setSheet(true)
                    ->setPassword('mtsnic');

                $sheetTitle = "Siswa";
                $sheet->setTitle($sheetTitle);
            },
        ];
    }



}
