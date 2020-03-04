<?php

namespace App\Exports;

use App\Office;
use Maatwebsite\Excel\Concerns\FromCollection;

class OfficeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Office::all();
    }
}
