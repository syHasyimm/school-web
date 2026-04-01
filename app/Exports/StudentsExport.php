<?php

namespace App\Exports;

use App\Enums\StudentStatus;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    use Exportable;

    protected int $rowNumber = 0;

    public function __construct(protected string $status = 'all') {}

    public function query()
    {
        $query = Student::with('user')->orderBy('created_at', 'desc');

        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Pendaftaran',
            'NIK',
            'No KK',
            'NISN',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'Alamat',
            'RT/RW',
            'Nama Ibu',
            'Nama Ayah',
            'Pekerjaan Orang Tua',
            'No HP',
            'Asal Sekolah',
            'Status',
            'Tanggal Daftar',
        ];
    }

    public function map($student): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $student->registration_code,
            "'" . $student->nik,
            "'" . $student->no_kk,
            "'" . $student->nisn,
            $student->full_name,
            $student->gender?->label() ?? '-',
            $student->birth_place,
            $student->birth_date?->format('d/m/Y'),
            $student->religion,
            $student->address,
            "{$student->rt}/{$student->rw}",
            $student->mother_name,
            $student->father_name ?? '-',
            $student->parent_occupation ?? '-',
            $student->parent_phone,
            $student->previous_school ?? '-',
            $student->status?->label() ?? '-',
            $student->created_at?->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1F4E79'],
                ],
                'alignment' => ['horizontal' => 'center'],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Data Pendaftar PPDB ' . now()->year;
    }
}
