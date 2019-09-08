<?php

namespace App\Exports;

use Cart;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IrExport implements FromView
{
    public function view(): View
    {
        return view('exports.ir', [
            'items' => Cart::getContent()
        ]);
    }
}
