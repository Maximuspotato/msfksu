<?php

namespace App\Exports;

use App\Traits\ConnectsToOracle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    use ConnectsToOracle;

    protected $data;

    public function __construct()
    {
        // Fetch data once when the class is initialized
        $this->data = $this->fetchFromOracle('SELECT * FROM EXT_PROD_PARA@msfss');
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        // Extract column names from the keys of the first row
        return $this->data->isNotEmpty() ? array_keys((array) $this->data->first()) : [];
    }
}