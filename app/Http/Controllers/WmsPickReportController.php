<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class WmsPickReportController extends Controller
{
    public function index(Request $request)
    {
        $columns = ['Workbook file', 'Pick status'];
        $workbooks = [];
        $rows = [];
        $files = Storage::disk('public')->allFiles('uploads');
        sort($files, SORT_NATURAL | SORT_FLAG_CASE);

        foreach ($files as $file) {
            if (!preg_match('/\.(xlsx|xls)$/i', $file)) {
                continue;
            }

            $path = Storage::disk('public')->path($file);
            $reader = IOFactory::createReaderForFile($path);
            $reader->setReadDataOnly(true);
            $sheetRows = $reader->load($path)->getActiveSheet()->toArray(null, true, true, false);

            if (count($sheetRows) === 0) {
                continue;
            }

            $pickStatus = preg_match('/_picked\.(xlsx|xls)$/i', $file) ? 'Picked' : 'Saved';
            $headers = [];
            $headerCounts = [];
            foreach ($sheetRows[0] as $header) {
                $header = trim((string) $header);
                if ($header === '') {
                    $headers[] = null;
                    continue;
                }

                $headerCounts[$header] = ($headerCounts[$header] ?? 0) + 1;
                $column = $headerCounts[$header] === 1
                    ? $header
                    : $header.' ('.$headerCounts[$header].')';
                $headers[] = $column;

                if ($pickStatus === 'Picked' && !in_array($column, $columns, true)) {
                    $columns[] = $column;
                }
            }

            $detailRows = [];
            foreach (array_slice($sheetRows, 1) as $sheetRow) {
                if (!array_filter($sheetRow, static function ($value) {
                    return $value !== null && $value !== '';
                })) {
                    continue;
                }

                $detailRows[] = $sheetRow;
            }

            $workbooks[] = [
                'file' => $file,
                'status' => $pickStatus,
                'headers' => $headers,
                'rows' => $detailRows,
            ];
        }

        $columnLookup = array_fill_keys($columns, true);
        foreach ($workbooks as $workbook) {
            foreach ($workbook['rows'] as $sheetRow) {
                $row = [
                    'Workbook file' => $workbook['file'],
                    'Pick status' => $workbook['status'],
                ];
                foreach ($workbook['headers'] as $index => $header) {
                    if ($header !== null && isset($columnLookup[$header])) {
                        $row[$header] = $sheetRow[$index] ?? '';
                    }
                }
                $rows[] = array_replace(array_fill_keys($columns, ''), $row);
            }
        }

        if ($request->query('export') === 'xlsx') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray($columns, null, 'A1');

            foreach ($rows as $index => $row) {
                $sheet->fromArray(array_values($row), null, 'A'.($index + 2));
            }

            return response()->streamDownload(static function () use ($spreadsheet) {
                (new Xlsx($spreadsheet))->save('php://output');
                $spreadsheet->disconnectWorksheets();
            }, 'wms-picking-details.xlsx');
        }

        return view('wms-pick-report', [
            'active' => 'wms',
            'columns' => $columns,
            'rows' => $rows,
        ]);
    }
}
