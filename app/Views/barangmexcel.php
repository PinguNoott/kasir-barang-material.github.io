<?php
require_once(ROOTPATH . 'Vendor/autoload.php'); // Adjust the path as necessary

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Sample setting (make sure this is defined correctly in your code)


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Get data from view variables
$websiteName = isset($setting->judul_website) ? $setting->judul_website : 'Default Website';
$websiteIcon = isset($setting->tab_icon) ? $setting->tab_icon : 'default-icon.png'; // Fallback value

// Set document properties
$spreadsheet->getProperties()
    ->setCreator('Your Name')
    ->setTitle('Nota')
    ->setSubject('Nota');

// Add report title
$sheet->setCellValue('A1', 'Laporan Barang Masuk');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->mergeCells('A1:F1'); // Adjust to include all columns

// Add website name and date range
$sheet->setCellValue('A2', $websiteName);
$sheet->setCellValue('A3', 'Tanggal : ' . $startDate . ' - ' . $endDate);
$sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A3')->getFont()->setSize(12);

// Add table headers
$sheet->setCellValue('A5', 'Nama Barang');
$sheet->setCellValue('B5', 'Kode Barang');
$sheet->setCellValue('C5', 'Quantity');
$sheet->setCellValue('D5', 'Harga Beli');
$sheet->setCellValue('E5', 'Total Harga');
$sheet->setCellValue('F5', 'Tanggal');

$sheet->getStyle('A5:F5')->getFont()->setBold(true);
$sheet->getStyle('A5:F5')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

// Add items and calculate total
$row = 6;
$totalAmount = 0;
foreach ($satu as $item) {
    $itemTotal = $item->quantity * $item->harga_beli; // Calculate total for each item
    
    // Format create_at to show only the date
    $createDate = (new DateTime($item->create_at))->format('d-m-Y');

    $sheet->setCellValue('A' . $row, $item->nama_barang);
    $sheet->setCellValue('B' . $row, $item->kode_barang);
    $sheet->setCellValue('C' . $row, number_format($item->quantity, 2, ',', '.'));
    $sheet->setCellValue('D' . $row, number_format($item->harga_beli, 2, ',', '.'));
    $sheet->setCellValue('E' . $row, 'Rp ' . number_format($itemTotal, 2, ',', '.'));
    $sheet->setCellValue('F' . $row, $createDate);

    $row++;
    $totalAmount += $itemTotal; // Add item total to overall total
}

// Apply borders to all table cells
$sheet->getStyle('A5:F' . ($row - 1))
    ->getBorders()
    ->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

// Add total amount below the table
$sheet->setCellValue('D' . $row, 'Total');
$sheet->setCellValue('E' . $row, 'Rp ' . number_format($totalAmount, 2, ',', '.'));
$sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);

// Adjust column widths
foreach (range('A', 'F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Create and output the Excel file
$writer = new Xlsx($spreadsheet);

// Format start and end dates for filename
$startDateFormatted = date('Y-m-d', strtotime($startDate));
$endDateFormatted = date('Y-m-d', strtotime($endDate));
$fileName = 'nota_' . $startDateFormatted . 'to' . $endDateFormatted . '.xlsx';

// Output the Excel file to the browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>