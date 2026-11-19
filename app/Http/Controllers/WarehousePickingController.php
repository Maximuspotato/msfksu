<?php

namespace App\Http\Controllers;

use App\Services\WarehousePickingService;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class WarehousePickingController extends Controller
{
    public function index()
    {
        return view('warehouse-picking', ['active' => 'wms']);
    }

    public function generate(Request $request, WarehousePickingService $service)
    {
        $validated = $request->validate([
            'target_doc_no' => 'required|string|max:100',
        ]);

        $documentNumber = trim($validated['target_doc_no']);
        $spreadsheet = $service->generate($documentNumber);
        $safeDocumentNumber = preg_replace('/[^A-Za-z0-9._-]/', '_', $documentNumber) ?: 'document';

        return response()->streamDownload(function () use ($spreadsheet) {
            try {
                (new Xlsx($spreadsheet))->save('php://output');
            } finally {
                $spreadsheet->disconnectWorksheets();
            }
        }, 'Picking-' . $safeDocumentNumber . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }
}
