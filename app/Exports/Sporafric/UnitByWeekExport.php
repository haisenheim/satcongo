<?php
namespace App\Exports\Sporafric;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Str;

class UnitByWeekExport implements FromView, ShouldAutoSize, WithTitle
{

    protected $unit;

    public function __construct($unit)
    {
        //dd($unit);
        $this->unit = $unit;
    }



    public function view(): View
    {
        //dd($this->table);
        return view('Rapports.Excel.Sporafric.unit_by_week', [
            'unit' => $this->unit
        ]);
    }

    public function title(): string
    {
        return Str::snake($this->unit['name']);
    }
}
