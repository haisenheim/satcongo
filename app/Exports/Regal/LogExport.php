<?php
namespace App\Exports\Regal;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LogExport implements FromView, ShouldAutoSize
{

    protected $data;
    protected $bold;
    protected $headers;

    public function __construct($data)
    {
        $this->data = $data;
    }

    private function getColors(){
        return ['orange'=>'FCE4D6','grey'=>'B4C6E7','green'=>'E1EDD9','yellow'=>'FDFD01','red'=>'FF3000'];
    }



    public function view(): View
    {
        return view('Rapports.Excel.Regal.log_export', [
            'data' => $this->data,
        ]);
    }
}
