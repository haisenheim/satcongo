<?php
namespace App\Exports\Regal;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParcoursExport implements FromView, ShouldAutoSize,WithTitle,WithStyles
{

    protected $data;
    protected $bold;
    protected $headers;

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
        $sheet->getStyle('B1')
         ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A2:J2')
        ->getFill()
        ->applyFromArray(
            [
                'fillType' => 'solid',
                'color' => ['rgb' => $this->_colors['green']],
                'font'=>['bold'=>true, 'size'=>15],
                'alignment'=>'center'
            ]
        );
        $sheet->getStyle('A3:J3')
        ->getFill()
        ->applyFromArray(
            [
                'fillType' => 'solid',
                'color' => ['rgb' => $this->_colors['grey']],
                'font'=>['bold'=>true, 'size'=>15],
                'alignment'=>'center'
            ]
        );
       // $sheet->getStyle('A3:G3')
        // ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

       // $sheet->getStyle('A3')->getFont()->setColor(new Color($this->_colors['yellow']));
       $rows[2] = [
        'font' => ['bold' => true, 'size'=>16],
        ];
        $rows[3] = [
            'font' => ['bold' => true, 'size'=>15],
            ];
    return $rows;

    }

    public function title(): string
    {
        return "Parcours";
    }



    public function view(): View
    {
        return view('Rapports.Excel.Regal.parcours', [
            'data' => $this->data,
        ]);
    }
}
