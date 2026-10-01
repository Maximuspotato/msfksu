<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\ProductExport;
use App\Exports\StockExport;
use App\Exports\PlanningExport;
use Maatwebsite\Excel\Facades\Excel;

class RunDailyExport extends Command
{
    protected $signature = 'export:daily';
    protected $description = 'Export 3 Daily Data Excel files in public/files';

    public function handle()
    {
        $this->info("Starting exports...");

        Excel::store(new ProductExport, 'Product.xlsx', 'public_files');
        $this->info("Product.xlsx saved/overwritten.");

        Excel::store(new StockExport, 'Stock.xlsx', 'public_files');
        $this->info("Stock.xlsx saved/overwritten.");

        Excel::store(new PlanningExport, 'Planning.xlsx', 'public_files');
        $this->info("Planning.xlsx saved/overwritten.");

        $this->info("All exports complete!");
    }
}