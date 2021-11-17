<?php

namespace App\Exports;

use App\Article;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CatalogExport implements FromView
{
    public function view(): View
    {
        return view('exports.catalog', [
            'items' => Article::all()
        ]);
    }
}
