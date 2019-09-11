<?php

namespace App\Exports;

use Cart;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RfqExport implements FromView
{
    public function view(): View
    {
        return view('exports.rfq', [
            'items' => Cart::getContent()
        ]);
    }
}
