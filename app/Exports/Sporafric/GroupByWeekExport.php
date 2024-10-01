<?php
namespace App\Exports\Sporafric;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GroupByWeekExport implements WithMultipleSheets
{
    use Exportable;
    protected $units;

    public function __construct($units)
    {
        $this->units = $units;
        //dd($units);
    }

    public function sheets(): array
    {
        $sheets = [];

        /* for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new InvoicesPerMonthSheet($this->year, $month);
        } */
        foreach($this->units as $unit){
           $sheets[] = new UnitByWeekExport($unit);
        }
        return $sheets;
    }


}
