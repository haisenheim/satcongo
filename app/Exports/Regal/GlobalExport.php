<?php
namespace App\Exports\Regal;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GlobalExport implements WithMultipleSheets
{
    use Exportable;
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];

        /* for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new InvoicesPerMonthSheet($this->year, $month);
        } */

        $sheets[] = new ParcoursExport($this->data['parcours']);
        $sheets[] = new ZoneExport($this->data['zones']);
       /* $sheets[] = new WeekendExport($this->data['weekend']['data'],$this->data['weekend']['style']);
        $sheets[] = new ViolationsExport($this->data['violations']['data'],$this->data['violations']['style']);
        $sheets[] = new EcoExport($this->data['eco']['data'],$this->data['eco']['style']);
        $sheets[] = new NuitExport($this->data['nuit']['data'],$this->data['nuit']['style']); */

        return $sheets;
    }


}
