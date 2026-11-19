<?php
namespace App\Services;

use DateTimeImmutable;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use RuntimeException;
use Throwable;

const HEADER_ALIASES = [
    'doc_no' => ['DOC No', 'Document No', 'Document Number', 'Doc No'],
    'article' => ['Article', 'Item', 'Item Code', 'Product Code', 'SKU', 'Code'],
    'quantity' => ['Quantity', 'Qty', 'Order Quantity', 'Required Quantity'],
    'box_per_pal' => ['Box per Pal', 'Boxes per Pallet', 'Box per Pallet'],
    'qty_per_pal' => ['Qty/Pal', 'Qty per Pal', 'Quantity per Pallet', 'Units per Pallet', 'Qty_Per_Pal'],
    'qty_per_box' => ['Qty per Box', 'Qty/Box', 'Units per Box', 'Qty_Per_Box'],
    'pack_size_mini' => ['Pack Size Mini', 'Mini Pack Size', 'Qty per Mini Pack'],
    'box_name' => ['Box Name', 'Packaging', 'Pack Name'],
    'weight_per_box' => ['Weight per Box', 'Box Weight', 'Weight'],
    'length' => ['Length'],
    'width' => ['Width'],
    'height' => ['Height'],
    'dimensions' => ['Dim (L/W/H)', 'Dimensions'],
    'tc' => ['TC', 'TC Status', 'Temperature Controlled', 'Temp Controlled', 'Temperature Control', 'RMKS_PRODUCTS'],
    'warehouse' => ['WH'],
    'id_place' => ['ID Place', 'IDPlace', 'Place ID', 'ID'],
    'description' => ['Description', 'Product Description', 'Item Description'],
    'location' => ['Location', 'Storage Location', 'Bin Location'],
    'aisle' => ['Aisle'],
    'rack' => ['Rack'],
    'level' => ['Level'],
    'stack' => ['Stack'],
    'quantity_available' => ['Quantity Available', 'Qty Available', 'Available Quantity', 'Stock Quantity', 'Quantity'],
    'batch' => ['Batch/Series', 'Batch', 'Series', 'Lot', 'Lot Number'],
    'expiry' => ['Expiry', 'Expiry Date', 'Expiration Date', 'Best Before'],
    'storage' => ['Storage', 'Pick Type', 'Picking Type'],
    'reminder' => ['Reminder', 'Notes'],
    'box_pal' => ['#Box/Pal', 'Box/Pal', 'Boxes/Pallet'],
    'no_pal' => ['No Pal', 'No Plt', '# Pal', 'Pallets', 'Number of Pallets'],
    'box_count' => ['# Box', 'Box Count', 'Number of Boxes'],
    'loose_count' => ['# of Min Pack', 'Min Packs', 'Loose Count'],
    'from' => ['From'],
    'to' => ['To'],
];

function normalizedHeader(string $header): string
{
    return strtolower((string)preg_replace('/[^a-z0-9]/i', '', trim($header)));
}

/** @return array{headers: array<string, int>, rows: list<array<string, mixed>>} */
function readWorkbookTable(string $path): array
{
    $spreadsheet = IOFactory::load($path);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray(null, true, false, false);
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);

    if ($data === []) {
        throw new RuntimeException('A source workbook is empty.');
    }

    $headers = [];
    foreach ($data[0] as $index => $value) {
        if ($value !== null && trim((string)$value) !== '') {
            $headers[normalizedHeader((string)$value)] = $index;
        }
    }

    $rows = [];
    foreach (array_slice($data, 1) as $row) {
        $record = [];
        foreach ($headers as $name => $index) {
            $record[$name] = $row[$index] ?? null;
        }
        if (count(array_filter($record, static fn($value): bool => $value !== null && trim((string)$value) !== '')) > 0) {
            $rows[] = $record;
        }
    }

    return ['headers' => $headers, 'rows' => $rows];
}

/** @param array<string, int> $headers */
function headerIndex(array $headers, string $field, bool $required = true, string $source = ''): ?int
{
    foreach (HEADER_ALIASES[$field] ?? [$field] as $alias) {
        $key = normalizedHeader($alias);
        if (array_key_exists($key, $headers)) {
            return $headers[$key];
        }
    }
    if ($required) {
        $message = 'Required column not found';
        if ($source !== '') {
            $message .= ' in ' . $source;
        }
        $message .= ': ' . (HEADER_ALIASES[$field][0] ?? $field);
        if ($headers !== []) {
            $message .= '. Available columns: ' . implode(', ', array_keys($headers));
        }
        throw new RuntimeException($message);
    }
    return null;
}

function valueFor(array $row, array $headers, string $field, $default = null)
{
    $index = headerIndex($headers, $field, false);
    if ($index === null) {
        return $default;
    }
    $aliases = HEADER_ALIASES[$field] ?? [$field];
    foreach ($aliases as $alias) {
        $key = normalizedHeader($alias);
        if (array_key_exists($key, $row)) {
            return $row[$key];
        }
    }
    return $default;
}

function cleanText($value): string
{
    return trim((string)($value ?? ''));
}

function numberValue($value, string $label, bool $allowZero = true): float
{
    if (!is_numeric($value)) {
        throw new RuntimeException("Invalid numeric value in {$label}.");
    }
    $number = (float)$value;
    if (!is_finite($number) || $number < 0 || (!$allowZero && $number <= 0)) {
        throw new RuntimeException("Invalid numeric value in {$label}.");
    }
    return $number;
}

function formatQuantity(float $value)
{
    return floor($value) === $value ? (int)$value : $value;
}

function formatExpiry($value): ?int
{
    if ($value === null || trim((string)$value) === '') {
        return null;
    }
    try {
        if (is_numeric($value)) {
            return ExcelDate::excelToDateTimeObject((float)$value)->getTimestamp();
        }
        $text = trim((string)$value);
        if (preg_match('/^\d{1,2}[\/-]\d{1,2}[\/-]\d{4}$/', $text)) {
            $format = strpos($text, '/') !== false ? '!d/m/Y' : '!d-m-Y';
            $date = DateTimeImmutable::createFromFormat($format, $text);
            $errors = DateTimeImmutable::getLastErrors();
            if ($date === false || ($errors !== false && ($errors['warning_count'] > 0 || $errors['error_count'] > 0))) {
                throw new RuntimeException('Invalid day/month/year date.');
            }
        } else {
            $date = new DateTimeImmutable($text);
        }
        return $date->getTimestamp();
    } catch (Throwable $error) {
        throw new RuntimeException('Invalid non-empty expiry date: ' . (string)$value, 0, $error);
    }
}

function displayExpiry($value): string
{
    $timestamp = formatExpiry($value);
    return $timestamp === null ? '' : date('d/m/Y', $timestamp);
}

function cleanLocation($value): string
{
    $location = trim((string)($value ?? ''));
    if ($location === '') {
        return '';
    }
    $parts = array_map('trim', explode('-', $location));
    if (count($parts) === 4 && preg_match('/^\d+(?:\.0+)?$/', $parts[2])) {
        $parts[2] = str_pad((string)(int)(float)$parts[2], 2, '0', STR_PAD_LEFT);
    }
    return implode('-', $parts);
}

function locationParts(string $location): array
{
    return array_map('strtoupper', explode('-', $location));
}

function isTemperatureControlled($value): bool
{
    $status = strtolower(trim((string)$value));
    return in_array($status, ['tc', 'yes', 'true', '1', 'temperature controlled', 'controlled'], true)
        || preg_match('/^tc\b/', $status) === 1;
}

/** @return list<int> FEFO order, with undated stock last. */
function sortedStockIndices(array $stock, callable $eligible): array
{
    $indices = [];
    foreach ($stock as $index => $line) {
        if ($line['available'] > 0 && $eligible($line)) {
            $indices[] = $index;
        }
    }
    usort($indices, static function (int $a, int $b) use ($stock): int {
        $expiryA = $stock[$a]['expiry_timestamp'] ?? PHP_INT_MAX;
        $expiryB = $stock[$b]['expiry_timestamp'] ?? PHP_INT_MAX;
        return ($expiryA <=> $expiryB)
            ?: strcmp($stock[$a]['location'], $stock[$b]['location'])
            ?: strcmp($stock[$a]['id_place'], $stock[$b]['id_place']);
    });
    return $indices;
}

function locationAisle(array $line): string
{
    return locationParts($line['location'])[0] ?? '';
}

function allocateFromLine(array &$stock, array &$linesByKey, int $stockIndex, array $requirement, string $storage, float $quantity, int $pallets, int $boxes): void
{
    if ($quantity <= 0) {
        return;
    }
    $line = &$stock[$stockIndex];
    $line['available'] -= $quantity;
    if (abs($line['available']) < 0.000001) {
        $line['available'] = 0.0;
    }
    $groupKey = implode('|', [$stockIndex, $requirement['article'], $storage]);
    if (!isset($linesByKey[$groupKey])) {
        $linesByKey[$groupKey] = [
            'storage' => $storage,
            'location' => $line['location'],
            'id_place' => $line['id_place'],
            'article' => $requirement['article'],
            'description' => $line['description'],
            'batch' => $line['batch'],
            'expiry' => $line['expiry'],
            'tc' => $requirement['tc'],
            'quantity' => 0.0,
            'pallets' => 0,
            'boxes' => 0,
            'box_per_pal' => $requirement['box_per_pal'],
            'qty_per_box' => $requirement['qty_per_box'],
            'pack_size_mini' => $requirement['pack_size_mini'],
            'weight_per_box' => $requirement['weight_per_box'],
            'length' => $requirement['length'],
            'width' => $requirement['width'],
            'height' => $requirement['height'],
            'box_name' => $requirement['box_name'],
            'qty_per_pal' => $requirement['qty_per_pal'],
            'warehouse' => $requirement['warehouse'],
            'all_box' => false,
        ];
    }
    $linesByKey[$groupKey]['quantity'] += $quantity;
    $linesByKey[$groupKey]['pallets'] += $pallets;
    $linesByKey[$groupKey]['boxes'] += $boxes;
    $linesByKey[$groupKey]['all_box'] = $linesByKey[$groupKey]['all_box'] || $line['available'] === 0.0;
}

function allocateQuantity(array &$stock, array &$linesByKey, array $indices, array $requirement, string $storage, float $wanted, float $unitSize, bool $wholeUnits): array
{
    $allocated = 0.0;
    $count = 0;
    foreach ($indices as $stockIndex) {
        if ($wanted - $allocated <= 0.000001) {
            break;
        }
        $available = $stock[$stockIndex]['available'];
        if ($wholeUnits) {
            $lineUnits = (int)floor(($available + 0.000001) / $unitSize);
            $needUnits = (int)ceil(($wanted - $allocated) / $unitSize);
            $takeUnits = min($lineUnits, $needUnits);
            $take = $takeUnits * $unitSize;
        } else {
            $takeUnits = 0;
            $take = min($available, $wanted - $allocated);
        }
        if ($take <= 0) {
            continue;
        }
        $pallets = $storage === 'Full Palette' ? $takeUnits : 0;
        $boxes = $storage === 'Full Box' ? $takeUnits : ($storage === 'Full Palette' ? $takeUnits * (int)$requirement['box_per_pal'] : 0);
        allocateFromLine($stock, $linesByKey, $stockIndex, $requirement, $storage, $take, $pallets, $boxes);
        $allocated += $take;
        $count += $takeUnits;
    }
    return ['quantity' => $allocated, 'count' => $count];
}

function allocateRequirement(array &$stock, array $requirement): array
{
    $lines = [];
    $qtyPerPal = $requirement['qty_per_pal'];
    $qtyPerBox = $requirement['qty_per_box'];
    $needPallets = $requirement['pallet_count'];

    $palletPriorities = [
        static fn(array $line): bool => in_array(locationAisle($line), ['DI', 'UM'], true) && count(locationParts($line['location'])) === 2,
        static fn(array $line): bool => in_array(locationAisle($line), ['B', 'C', 'D'], true)
            && $line['available'] + 0.000001 >= $qtyPerPal,
    ];
    foreach ($palletPriorities as $eligible) {
        $indices = sortedStockIndices($stock, $eligible);
        $result = allocateQuantity($stock, $lines, $indices, $requirement, 'Full Palette', $needPallets * $qtyPerPal, $qtyPerPal, true);
        $needPallets -= $result['count'];
    }

    $needBoxes = $requirement['box_count'];
    $boxPriorities = [
        static fn(array $line): bool => in_array(locationAisle($line), ['B', 'C', 'D'], true) && (locationParts($line['location'])[2] ?? '') === '01',
        static fn(array $line): bool => in_array(locationAisle($line), ['B', 'C', 'D'], true) && (locationParts($line['location'])[2] ?? '') !== '01',
        static fn(array $line): bool => locationAisle($line) === 'UM' && count(locationParts($line['location'])) === 4,
    ];
    foreach ($boxPriorities as $eligible) {
        $indices = sortedStockIndices($stock, $eligible);
        $result = allocateQuantity($stock, $lines, $indices, $requirement, 'Full Box', $needBoxes * $qtyPerBox, $qtyPerBox, true);
        $needBoxes -= $result['count'];
    }

    $needLoose = max(0.0, $requirement['quantity'] - array_sum(array_column($lines, 'quantity')));
    foreach ([
        static fn(array $line): bool => locationAisle($line) === 'L',
        static fn(array $line): bool => true,
    ] as $eligible) {
        $indices = sortedStockIndices($stock, $eligible);
        $result = allocateQuantity($stock, $lines, $indices, $requirement, 'Loose', $needLoose, 1, false);
        $needLoose -= $result['quantity'];
        if ($needLoose <= 0.000001) {
            break;
        }
    }

    $picked = array_sum(array_column($lines, 'quantity'));
    return [
        'lines' => array_values($lines),
        'picked' => $picked,
        'shortage' => max(0.0, $requirement['quantity'] - $picked),
    ];
}

function templateHeaderRow(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet): int
{
    $maxRow = min(20, $sheet->getHighestRow());
    $maxColumn = Coordinate::columnIndexFromString($sheet->getHighestColumn());
    $bestRow = 0;
    $bestScore = 0;
    for ($row = 1; $row <= $maxRow; $row++) {
        $score = 0;
        for ($column = 1; $column <= $maxColumn; $column++) {
            $value = trim((string)$sheet->getCellByColumnAndRow($column, $row)->getValue());
            if ($value === '') {
                continue;
            }
            foreach (HEADER_ALIASES as $aliases) {
                if (in_array(normalizedHeader($value), array_map(static fn(string $alias): string => normalizedHeader($alias), $aliases), true)) {
                    $score++;
                    break;
                }
            }
        }
        if ($score > $bestScore) {
            $bestScore = $score;
            $bestRow = $row;
        }
    }
    if ($bestRow === 0) {
        throw new RuntimeException('Could not locate the column-header row in Automatic.xlsx.');
    }
    return $bestRow;
}

function outputField(string $header): ?string
{
    foreach (HEADER_ALIASES as $field => $aliases) {
        if (in_array(normalizedHeader($header), array_map(static fn(string $alias): string => normalizedHeader($alias), $aliases), true)) {
            return $field;
        }
    }
    return null;
}

function outputRow(array $pick, int $boxCounter): array
{
    switch ($pick['storage']) {
        case 'Full Palette':
            $reminder = 'Full Palettes';
            $boxLabel = $pick['pallets'] . ' Pal / ' . $pick['boxes'] . ' Box';
            break;
        case 'Full Box':
            $reminder = 'Full Box';
            $boxLabel = $pick['boxes'] . ' Box';
            break;
        default:
            $reminder = 'Loose';
            $boxLabel = '';
    }
    if ($pick['all_box']) {
        $reminder .= ' - All box';
    }
    $miniPackCount = $pick['pack_size_mini'] > 0
        ? formatQuantity($pick['quantity'] / $pick['pack_size_mini'])
        : formatQuantity($pick['quantity']);

    return [
        'storage' => $pick['storage'],
        'location' => $pick['location'],
        'id_place' => $pick['id_place'],
        'article' => $pick['article'],
        'description' => $pick['description'],
        'box_name' => $pick['box_name'],
        'batch' => $pick['batch'],
        'expiry' => $pick['expiry'],
        'quantity' => formatQuantity($pick['quantity']),
        'quantity_available' => formatQuantity($pick['quantity']),
        'reminder' => $reminder,
        'box_pal' => $boxLabel,
        'no_pal' => $pick['pallets'],
        'box_count' => $pick['boxes'],
        'loose_count' => $pick['storage'] === 'Loose' ? $miniPackCount : '',
        'from' => $pick['storage'] === 'Loose' ? '' : $boxCounter,
        'to' => $pick['storage'] === 'Loose' || $pick['boxes'] === 0 ? '' : $boxCounter + $pick['boxes'] - 1,
        'box_per_pal' => $pick['box_per_pal'],
        'qty_per_pal' => $pick['qty_per_pal'],
        'qty_per_box' => $pick['qty_per_box'],
        'pack_size_mini' => $pick['pack_size_mini'],
        'weight_per_box' => $pick['storage'] === 'Loose' ? '' : $pick['weight_per_box'],
        'length' => $pick['storage'] === 'Loose' ? '' : $pick['length'],
        'width' => $pick['storage'] === 'Loose' ? '' : $pick['width'],
        'height' => $pick['storage'] === 'Loose' ? '' : $pick['height'],
        'dimensions' => $pick['storage'] === 'Loose' ? '' : implode(' / ', [$pick['length'], $pick['width'], $pick['height']]),
        'tc' => $pick['tc'] ? 'TC' : 'Non-TC',
    ];
}

function writePickingSheet(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, int $headerRow, string $title, array $picks): void
{
    $sheet->setTitle($title);

    $lastColumn = Coordinate::columnIndexFromString($sheet->getHighestColumn());
    $lastRow = $sheet->getHighestRow();
    $styleSourceRow = $headerRow + 1;
    for ($row = $headerRow + 1; $row <= $lastRow; $row++) {
        for ($column = 1; $column <= $lastColumn; $column++) {
            $sheet->getCellByColumnAndRow($column, $row)->setValue(null);
        }
    }

    usort($picks, static fn(array $a, array $b): int =>
        (['Full Palette' => 0, 'Full Box' => 1, 'Loose' => 2][$a['storage']] <=> ['Full Palette' => 0, 'Full Box' => 1, 'Loose' => 2][$b['storage']])
        ?: strcmp($a['location'], $b['location'])
        ?: strcmp($a['id_place'], $b['id_place'])
        ?: strcmp($a['article'], $b['article'])
    );

    $headers = [];
    for ($column = 1; $column <= $lastColumn; $column++) {
        $headers[$column] = trim((string)$sheet->getCellByColumnAndRow($column, $headerRow)->getValue());
    }
    $counter = 1;
    foreach ($picks as $offset => $pick) {
        $rowNumber = $headerRow + 1 + $offset;
        if ($rowNumber > $lastRow && $lastRow >= $styleSourceRow) {
            for ($column = 1; $column <= $lastColumn; $column++) {
                $sheet->duplicateStyle(
                    $sheet->getStyleByColumnAndRow($column, $styleSourceRow),
                    Coordinate::stringFromColumnIndex($column) . $rowNumber
                );
            }
        }
        $rowData = outputRow($pick, $counter);
        foreach ($headers as $column => $header) {
            $field = outputField($header);
            if ($field === null) {
                continue;
            }
            $sheet->getCellByColumnAndRow($column, $rowNumber)->setValue($rowData[$field] ?? '');
        }
        if ($pick['storage'] !== 'Loose') {
            $counter += $pick['boxes'];
        }
    }
}


class WarehousePickingService
{
    public function generate(string $target_doc_no): Spreadsheet
    {
        $sourcePaths = [
            'planning' => public_path('files/Planning.xlsx'),
            'product' => public_path('files/Product.xlsx'),
            'stock' => public_path('files/Stock.xlsx'),
            'template' => public_path('files/Automatic.xlsx'),
        ];
        $sourceNames = [
            'planning' => 'Planning.xlsx',
            'product' => 'Product.xlsx',
            'stock' => 'Stock.xlsx',
            'template' => 'Automatic.xlsx',
        ];
        foreach ($sourcePaths as $name => $path) {
            if (!is_file($path) || !is_readable($path)) {
                throw new RuntimeException($sourceNames[$name] . ' is missing or unreadable at ' . $path . '.');
            }
        }

        $planning = readWorkbookTable($sourcePaths['planning']);
        $products = readWorkbookTable($sourcePaths['product']);
        $stockData = readWorkbookTable($sourcePaths['stock']);

        headerIndex($planning['headers'], 'doc_no', true, 'Planning.xlsx');
        headerIndex($planning['headers'], 'article', true, 'Planning.xlsx');
        headerIndex($planning['headers'], 'quantity', true, 'Planning.xlsx');
        headerIndex($products['headers'], 'article', true, 'Product.xlsx');
        headerIndex($products['headers'], 'qty_per_pal', true, 'Product.xlsx');
        headerIndex($products['headers'], 'qty_per_box', true, 'Product.xlsx');
        headerIndex($products['headers'], 'warehouse', true, 'Product.xlsx');
        headerIndex($stockData['headers'], 'id_place', true, 'Stock.xlsx');
        headerIndex($stockData['headers'], 'article', true, 'Stock.xlsx');
        headerIndex($stockData['headers'], 'quantity_available', true, 'Stock.xlsx');
        if (headerIndex($stockData['headers'], 'location', false) === null) {
            foreach (['aisle', 'rack', 'level', 'stack'] as $locationPart) {
                headerIndex($stockData['headers'], $locationPart, true, 'Stock.xlsx');
            }
        }

        $productByArticle = [];
        foreach ($products['rows'] as $row) {
            $article = cleanText(valueFor($row, $products['headers'], 'article'));
            if ($article === '') {
                continue;
            }
            $productByArticle[$article] = [
                'qty_per_pal' => valueFor($row, $products['headers'], 'qty_per_pal'),
                'qty_per_box' => valueFor($row, $products['headers'], 'qty_per_box'),
                'box_per_pal' => valueFor($row, $products['headers'], 'box_per_pal', ''),
                'pack_size_mini' => valueFor($row, $products['headers'], 'pack_size_mini', 1),
                'box_name' => cleanText(valueFor($row, $products['headers'], 'box_name', '')),
                'weight_per_box' => valueFor($row, $products['headers'], 'weight_per_box', ''),
                'length' => valueFor($row, $products['headers'], 'length', ''),
                'width' => valueFor($row, $products['headers'], 'width', ''),
                'height' => valueFor($row, $products['headers'], 'height', ''),
                'tc' => isTemperatureControlled(valueFor($row, $products['headers'], 'tc', '')),
                'warehouse' => cleanText(valueFor($row, $products['headers'], 'warehouse', '')),
            ];
        }

        $requirements = [];
        foreach ($planning['rows'] as $row) {
            if (cleanText(valueFor($row, $planning['headers'], 'doc_no')) !== $target_doc_no) {
                continue;
            }
            $article = cleanText(valueFor($row, $planning['headers'], 'article'));
            $quantity = numberValue(valueFor($row, $planning['headers'], 'quantity'), 'Planning Quantity');
            if ($quantity <= 0) {
                continue;
            }
            if (!isset($productByArticle[$article])) {
                throw new RuntimeException("Product master data is missing Article {$article}.");
            }
            $product = $productByArticle[$article];
            $product['qty_per_pal'] = numberValue($product['qty_per_pal'], "Qty/Pal for Article {$article}", false);
            $product['qty_per_box'] = numberValue($product['qty_per_box'], "Qty per Box for Article {$article}", false);
            $rawBoxPerPal = $product['box_per_pal'];
            $boxPerPal = ($rawBoxPerPal === null || trim((string)$rawBoxPerPal) === '')
                ? 0
                : numberValue($rawBoxPerPal, "Box per Pal for Article {$article}");
            $product['box_per_pal'] = $boxPerPal > 0 ? $boxPerPal : $product['qty_per_pal'] / $product['qty_per_box'];
            $product['pack_size_mini'] = numberValue($product['pack_size_mini'] ?: 1, "Pack Size Mini for Article {$article}", false);
            $palletCount = (int)floor($quantity / $product['qty_per_pal']);
            $palletQuantity = $palletCount * $product['qty_per_pal'];
            $qtyLeft = $quantity - $palletQuantity;
            $boxCount = (int)floor($qtyLeft / $product['qty_per_box']);
            $boxQuantity = $boxCount * $product['qty_per_box'];
            $key = $article;
            if (!isset($requirements[$key])) {
                $requirements[$key] = array_merge([
                    'article' => $article,
                    'quantity' => 0.0,
                    'pallet_count' => 0,
                    'box_count' => 0,
                    'loose_quantity' => 0.0,
                ], $product);
            }
            $requirements[$key]['quantity'] += $quantity;
            $requirements[$key]['pallet_count'] += $palletCount;
            $requirements[$key]['box_count'] += $boxCount;
            $requirements[$key]['loose_quantity'] += $qtyLeft - $boxQuantity;
        }
        if ($requirements === []) {
            throw new RuntimeException("No planning lines found for document {$target_doc_no}.");
        }

        $stock = [];
        foreach ($stockData['rows'] as $row) {
            $article = cleanText(valueFor($row, $stockData['headers'], 'article'));
            if (!isset($productByArticle[$article])) {
                continue;
            }
            $available = numberValue(valueFor($row, $stockData['headers'], 'quantity_available'), 'Stock Quantity Available');
            $product = $productByArticle[$article];
            $expiry = valueFor($row, $stockData['headers'], 'expiry', '');
            $locationValue = valueFor($row, $stockData['headers'], 'location', '');
            if (cleanText($locationValue) === '') {
                $locationParts = [];
                foreach (['aisle', 'rack', 'level', 'stack'] as $locationPart) {
                    $locationParts[] = cleanText(valueFor($row, $stockData['headers'], $locationPart, ''));
                }
                while ($locationParts !== [] && end($locationParts) === '') {
                    array_pop($locationParts);
                }
                $locationValue = implode('-', $locationParts);
            }
            $stock[] = array_merge([
                'id_place' => cleanText(valueFor($row, $stockData['headers'], 'id_place')),
                'article' => $article,
                'description' => cleanText(valueFor($row, $stockData['headers'], 'description', '')),
                'location' => cleanLocation($locationValue),
                'available' => $available,
                'batch' => cleanText(valueFor($row, $stockData['headers'], 'batch', '')),
                'expiry' => displayExpiry($expiry),
                'expiry_timestamp' => formatExpiry($expiry),
            ], $product);
        }

        $allPicks = [];
        $summary = [];
        foreach ($requirements as $article => $requirement) {
            $articleStock = [];
            foreach ($stock as $index => $line) {
                if ($line['article'] === $article) {
                    $articleStock[$index] = $line;
                }
            }
            $result = allocateRequirement($articleStock, $requirement);
            foreach ($articleStock as $index => $updatedLine) {
                $stock[$index]['available'] = $updatedLine['available'];
            }
            foreach ($result['lines'] as $pick) {
                $allPicks[] = $pick;
            }
            $summary[] = [
                'article' => $article,
                'requested' => $requirement['quantity'],
                'picked' => $result['picked'],
                'shortage' => $result['shortage'],
            ];
        }

        $tcPicks = array_values(array_filter($allPicks, static fn(array $pick): bool => $pick['tc'] && $pick['storage'] !== 'Loose'));
        $ambientPicks = array_values(array_filter($allPicks, static fn(array $pick): bool => !$pick['tc'] && $pick['storage'] !== 'Loose'));
        $loosePicks = array_values(array_filter($allPicks, static fn(array $pick): bool => $pick['storage'] === 'Loose'));
        $logPicks = array_values(array_filter(
            $allPicks,
            static fn(array $pick): bool => normalizedHeader($pick['warehouse']) !== 'epz1'
        ));

        $templateBook = IOFactory::load($sourcePaths['template']);
        $prototype = $templateBook->getActiveSheet();
        $headerRow = templateHeaderRow($prototype);
        $output = $templateBook;
        $summarySheet = $output->createSheet(0);
        $summarySheet->setTitle('Validation Summary');
        $summarySheet->fromArray(
            [['Article', 'Requested Items', 'Picked Items', 'Potential Shortage'], ...array_map(
                static fn(array $line): array => [
                    $line['article'],
                    formatQuantity($line['requested']),
                    formatQuantity($line['picked']),
                    formatQuantity($line['shortage']),
                ],
                $summary
            )],
            null,
            'A1'
        );
        $summarySheet->fromArray([
            ['Total Items Requested', formatQuantity(array_sum(array_column($summary, 'requested')))],
            ['Total Items Picked', formatQuantity(array_sum(array_column($summary, 'picked')))],
            ['Potential Shortage', formatQuantity(array_sum(array_column($summary, 'shortage')))],
            ['Total Pallets', array_sum(array_column($allPicks, 'pallets'))],
            ['Total Boxes', array_sum(array_column($allPicks, 'boxes'))],
            ['Total Loose Items', formatQuantity(array_sum(array_map(static fn(array $pick): float => $pick['storage'] === 'Loose' ? $pick['quantity'] : 0.0, $allPicks)))],
        ], null, 'F1');
        $summarySheet->getStyle('A1:D1')->getFont()->setBold(true);
        $summarySheet->getStyle('F1:F6')->getFont()->setBold(true);

        writePickingSheet($prototype, $headerRow, 'TC Products', $tcPicks);
        $ambientSheet = clone $prototype;
        $ambientSheet->setTitle('Non-TC Products');
        $output->addSheet($ambientSheet);
        writePickingSheet($ambientSheet, $headerRow, 'Non-TC Products', $ambientPicks);
        $looseSheet = clone $prototype;
        $looseSheet->setTitle('Loose');
        $output->addSheet($looseSheet);
        writePickingSheet($looseSheet, $headerRow, 'Loose', $loosePicks);
        $logSheet = clone $prototype;
        $logSheet->setTitle('Log');
        $output->addSheet($logSheet);
        writePickingSheet($logSheet, $headerRow, 'Log', $logPicks);

        $output->setActiveSheetIndex(0);
        return $output;
    }
}
