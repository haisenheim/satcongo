<?php
namespace App\Exports\Sporafric;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GroupConsoByWeekExport implements WithMultipleSheets
{
    use Exportable;
    protected $units;

    public function __construct($donnees)
    {
        //dd($unit);
        $this->units = $donnees;
    }





    public function sheets(): array
    {
        $sheets = [];

        foreach($this->units as $unit){
            $sheets[] = new UnitConsoByWeekExport($unit);
        }



        return $sheets;
    }
}
