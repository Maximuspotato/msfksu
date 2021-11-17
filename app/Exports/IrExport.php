<?php

namespace App\Exports;

use Cart;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromView;

class IrExport implements FromView
{
    public function view(): View
    {
        if (Session::get('language') == 'fr') {
            return view('exports.frenchIr', [
                'items' => Cart::getContent()
            ]);
        } else {
            return view('exports.ir', [
                'items' => Cart::getContent()
            ]);
        }
    }
}
