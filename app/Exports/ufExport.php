<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ufExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //dd(Session::get('articles'));
        $articles = array();
        foreach (Session::get('articles') as $art) {
            array_push($articles,[
                "product" => strip_tags($art['ART']),
                "desc" => $art['ART_DES1'],
                "suppier" => "KSU",
                "oum" => "PCE",
                "min" => 1,
                "price" => $art['PRICE'],
                "soq" => 1,
                "moq" => $art['ART_COND_VTE'],
                "comment" => $art['ART_ZZ_ON_LINE_OBS']
            ]);
        }
        return collect($articles);
    }

    public function headings(): array
    {
        return [
            'ProductCode',
            'Product Description',
            'Supplier Code',
            'UoM',
            'Min. Qty',
            'Unit Price',
            'SoQ Rounding',
            'Min. Order Qty.',
            'Comment'
        ];
    }
}
