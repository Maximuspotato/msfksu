<?php

namespace App\Imports;

use App\Donation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DonationsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Donation([
            'article_code' => $row['article_code'],
            'desc_eng' => $row['desc_eng'],
            'purchase_price' => $row['purchase_price'],
            'currency' => $row['currency'],
            'quantity' => $row['quantity'],
            'batch' => $row['batch'],
            'expiry_date' => $row['expiry_date'],
            'stock_owner' => $row['stock_owner'],
            'comments' => $row['comments'],
            'pics' => $row['pics'],
        ]);
    }
}
