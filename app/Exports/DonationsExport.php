<?php

namespace App\Exports;

use App\Donation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DonationsExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('exports.donations', [
            'items' => Donation::all()
        ]);
    }
}
