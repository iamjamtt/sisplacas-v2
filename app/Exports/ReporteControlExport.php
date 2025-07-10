<?php

namespace App\Exports;

use App\Models\Control;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReporteControlExport implements FromCollection, WithHeadings, WithStyles, WithEvents, ShouldAutoSize
{
    public function collection()
    {
        return Control::with(['vehiculo'])
            ->get()
            ->map(function ($control) {
                return [
                    'ID' => $control->id,
                    'Placa' => $control->vehiculo->placa,
                    'Conductor' => $control->vehiculo->nombre_completo,
                    'Marca' => $control->vehiculo->marca,
                    'Modelo' => $control->vehiculo->modelo,
                    'Fecha Ingreso' => $control->ingreso->format('H:i:s d/m/Y'),
                    'Fecha Salida' => $control->salida ? $control->salida->format('H:i:s d/m/Y') : '-',
                    'Tiene Sanción' => $control->vehiculo->tieneSancion ? 'Sí' : 'No',
                    'Sanción' => $control->vehiculo->sancion ? $control->vehiculo->sancion->nombre : 'N/A',
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Placa', 'Conductor', 'Marca', 'Modelo', 'Fecha Ingreso', 'Fecha Salida', 'Tiene Sanción', 'Sanción'];
    }

     public function styles(Worksheet $sheet)
    {
        return [
            1 => [ // Fila de cabecera
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'D9E1F2'],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();
                $cellRange = "A1:{$lastColumn}{$lastRow}";

                // Bordes
                $sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Centrar columnas específicas
                $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("D2:D{$lastRow}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("E2:E{$lastRow}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("F2:F{$lastRow}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("G2:G{$lastRow}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("H2:H{$lastRow}")->getAlignment()->setHorizontal('center');

                // Cabecera fija
                $sheet->freezePane('A2');
            },
        ];
    }
}
