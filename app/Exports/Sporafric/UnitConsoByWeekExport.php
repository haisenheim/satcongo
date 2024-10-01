<?php
namespace App\Exports\Sporafric;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Str;

class UnitConsoByWeekExport implements WithStyles, FromView, ShouldAutoSize, WithTitle, WithColumnWidths
{
    use Exportable;
    protected $donnees;

    public function __construct($donnees)
    {
        //dd($unit);
        $this->donnees = $donnees;
    }

    public function getWeeks(){
        return $this->donnees['Consommation']['r'];
    }

    public function columnWidths(): array
    {
        return [
            'D' => 23,
            'E'=>23,
            'F' => 23,
            'G'=>23,
            'I' => 23,
            'J'=>23
        ];
    }



    public function view(): View
    {
        //dd($this->table);
        return view('Rapports.Excel.unit_conso_by_week', [
            'unit' => $this->donnees
        ]);
    }

    private function getColors(){
        return ['orange'=>'FCE4D6','grey'=>'B4C6E7','green'=>'E1EDD9','yellow'=>'FDFD01','red'=>'FF3000'];
    }

    private function fillCells(Worksheet $sheet, $marge,$color){
       return $sheet->getStyle($marge)
        ->getFill()

        ->applyFromArray(
            [
                'fillType' => 'solid',
                'rotation' => 45,
                'color' => ['rgb' => $color],
                'font'=>['bold'=>true, 'size'=>15],
                'alignment'=>'center'
            ]
        );
    }

    public function title(): string
    {
        return Str::snake($this->donnees['unit']);
    }

    public function styles(Worksheet $sheet)
    {
        $weeks = $this->donnees['Consommation']['r'];
        $begin = 7;
        foreach($weeks as $week){
            $shift = count($week['r']);
            $end = $begin + $shift -1;
            $marge = 'A'.$begin.':A'.$end;
            $t1 = $end+1;
            $t2=$end+2;
            $marge2 =  'A'.$t1.':A'.$t2;
            $m_b = 'B'.$t1.':B'.$t2;
            $m_c = 'C'.$t1.':C'.$t2;
            $m_dh = 'D'.$t1.':H'.$t2;
            $m_ij = 'I'.$t1.':J'.$t2;
            $m_k = 'K'.$t1.':K'.$t2;
            $m_l = 'L'.$t1.':L'.$t2;
            $m_mn = 'M'.$t1.':N'.$t2;

            $sheet->getStyle('A'.$begin.':A'.$end)->getFont()
            ->setColor(new Color('FE4800'))
            ->setBold(true)
            ->setSize(20);





            $sheet->getStyle($marge)
            ->getFill()

            ->applyFromArray(
                [
                    'fillType' => 'solid',
                    'rotation' => 45,
                    'color' => ['rgb' => 'B4C6E7'],
                    'font'=>['bold'=>true, 'size'=>15],
                    'alignment'=>'center'
                ]
            );

            $this->fillCells($sheet,$m_b,$this->getColors()['orange']);
            $this->fillCells($sheet,$m_c,$this->getColors()['orange']);
            $this->fillCells($sheet,$m_dh,$this->getColors()['green']);
            $this->fillCells($sheet,$m_ij,$this->getColors()['yellow']);
            $this->fillCells($sheet,$m_k,$this->getColors()['orange']);
            $this->fillCells($sheet,$m_l,$this->getColors()['yellow']);
            $this->fillCells($sheet,$m_mn,$this->getColors()['grey']);

           $sheet->mergeCells($marge);
           $sheet->getStyle($marge)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setTextRotation(45)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle($marge2)
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->mergeCells($marge2);
            $begin = $end +3;
        }
        $this->fillCells($sheet,'M5:N6',$this->getColors()['grey']);
        $this->fillCells($sheet,'C5:C6',$this->getColors()['orange']);
        $this->fillCells($sheet,'K5:K6',$this->getColors()['orange']);
        $this->fillCells($sheet,'D5:H6',$this->getColors()['green']);
        $this->fillCells($sheet,'I5:J6',$this->getColors()['yellow']);
        $this->fillCells($sheet,'L5:L6',$this->getColors()['yellow']);

        $sheet->getStyle('A0:N80')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A0:N80')
       // ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->getFont()
            ->setName('Calibri')
           // ->setBold(true)
            ->setSize(11)
            ;

        $sheet->mergeCells('B5:B6')
        ->mergeCells('C5:C6')
        ->mergeCells('A5:A6')
        ->mergeCells('H5:H6')
        ->mergeCells('K5:K6')
        ->mergeCells('L5:L6')
        ->mergeCells('M5:M6')
        ->mergeCells('N5:N6');

        $sheet->getStyle('B5:B6')
            ->getFill()

            ->applyFromArray(
                [
                    'fillType' => 'solid',
                    'rotation' => 45,
                    'color' => ['rgb' => 'B4C6E7'],
                    'alignment'=>'center'
                ]
            );

         return [
            // Style the first row as bold text.

                    5   => [
                        'font' => ['bold' => true, 'size'=>14],
                        'color' => ['rgb' => 'FFC300'],
                    ],
                    6   => [
                        'font' => ['bold' => true, 'size'=>14],
                        'color' => ['rgb' => 'FFC300'],
                    ],

           // 'C1' => ['font'=>['bold'=>true, 'size'=>28],],
        ];
    }
}
