<?php
namespace App\Exports\Regal;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ZoneExport implements FromView, ShouldAutoSize,WithTitle, WithStyles
{

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    protected $_colors = ['orange'=>'F25800','grey'=>'B4C6E7','green'=>'008000','yellow'=>'FDFD01','red'=>'FF3000'];



    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('B1')
        ->getFill()
        ->applyFromArray(
            [
                'fillType' => 'solid','rotation' => 0,
                'color' => ['rgb' => $this->_colors['orange']],
                'font'=>['bold'=>true, 'size'=>28],
                'alignment'=>'center'
            ]
        );
        $sheet->getStyle('A')
         ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('B')
         ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('C')
         ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

         $sheet->getStyle('1')
         ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A3:G3')
        ->getFill()
        ->applyFromArray(
            [
                'fillType' => 'solid',
                'color' => ['rgb' => $this->_colors['green']],
                'font'=>['bold'=>true, 'size'=>14],
                'alignment'=>'center'
            ]
        );
        $rows[3] = [
            'font' => ['bold' => true, 'size'=>16],
        ];
        $rows['A4'] = [
            'font' => ['bold' => true, 'size'=>20],
        ];

        return $rows;

    }


    public function title(): string
    {
        return "Zones";
    }



    public function view(): View
    {
        return view('Rapports.Excel.Regal.zones', [
            'data' => $this->data,
        ]);
    }
}
