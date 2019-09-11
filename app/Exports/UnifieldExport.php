<?php

namespace App\Exports;

use Cart;
use Illuminate\Contracts\View\View;
//use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromView;
//use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UnifieldExport implements FromView, ShouldAutoSize
//, WithEvents
{
    public function view(): View
    {
        return view('exports.items', [
            'items' => Cart::getContent()
        ]);
    }

    /**
     * @return array
     */
    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class    => function(AfterSheet $event) {
    //             $cellRange = 'A1:H1'; // All headers
    //             $event->sheet->getStyle($cellRange)->getFill()
    //       ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    //       ->getStartColor()->setARGB('ffcc99');
    //         },
    //     ];
    // }
}
