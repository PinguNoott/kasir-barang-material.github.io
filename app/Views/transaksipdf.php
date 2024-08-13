<?php
require_once(ROOTPATH . 'Vendor/autoload.php'); // Adjust the path as necessary

class CustomPDF extends TCPDF {
    private $logoPath;

    public function __construct($logoPath, $orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = true, $pdfa = false) {
        $this->logoPath = $logoPath;
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
    }

    // Page header
    public function Header() {
        $this->SetAlpha(0.2);

        // Get page dimensions
        $pageWidth = $this->getPageWidth();
        $pageHeight = $this->getPageHeight();

        // Set margins
        $leftMargin = $this->lMargin;
        $rightMargin = $this->rMargin;
        $topMargin = $this->tMargin;

        // Calculate image dimensions
        $imageWidth = $pageWidth - ($leftMargin + $rightMargin); // Full page width minus margins
        $imageHeight = 0; // Height set to 0 to maintain aspect ratio

        // Position and add the image
        $this->Image($this->logoPath, $leftMargin, $topMargin, $imageWidth, $imageHeight, 'PNG', '', 'T', true, 150, '', false, false, 0, false, false, false);
        $this->SetAlpha(1); // Reset opacity to default
    }

    // Page footer
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

// Create a new instance of the custom TCPDF class
$logoPath = 'images/' . (isset($setting->tab_icon) ? $setting->tab_icon : 'default-icon.png');
$pdf = new CustomPDF($logoPath);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Nota');
$pdf->SetSubject('Nota');

// Set margins
$pdf->SetMargins(10, 20, 10); // Adjust margins as needed

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 10);

// Get data from view variables
$websiteName = isset($setting->judul_website) ? $setting->judul_website : 'Default Website';
$startDate = isset($startDate) ? $startDate : '0000-00-00';
$endDate = isset($endDate) ? $endDate : '9999-12-31';

// Add report title
$pdf->SetXY(10, 20); // Set X and Y position
$pdf->SetFont('helvetica', 'B', 16); // Larger font for report title
$pdf->Cell(0, 10, 'Laporan Transaksi', 0, 1, 'L'); // Report title, aligned to the left

// Add website name and date range
$pdf->SetXY(10, 35); // Adjust Y position for the website name and date range
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, $websiteName, 0, 1, 'L'); // Website name, aligned to the left
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Tanggal Transaksi: ' . $startDate . ' - ' . $endDate, 0, 1, 'L'); // Date range, aligned to the left

// Prepare HTML content
$html = '<table border="1" cellspacing="0" cellpadding="4">';
$html .= '<thead><tr><th>Nama</th><th>Kode</th><th>Jumlah Bayar</th><th>Tanggal</th></tr></thead>';
$html .= '<tbody>';

// Add items and calculate total
$totalAmount = 0;
foreach ($satu as $item) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($item->no_transaksi, ENT_QUOTES, 'UTF-8') . '</td>';
    $html .= '<td>' . htmlspecialchars($item->kode_keranjang, ENT_QUOTES, 'UTF-8') . '</td>';
    $html .= '<td>Rp ' . number_format($item->jumlah_transaksi, 2, ',', '.') . '</td>';
    $html .= '<td>' . htmlspecialchars($item->tanggal, ENT_QUOTES, 'UTF-8') . '</td>';
    $html .= '</tr>';
    $totalAmount += $item->jumlah_transaksi; // Calculate total amount
}

$html .= '</tbody>';
$html .= '</table>';

// Output the HTML table
$pdf->writeHTML($html, true, false, true, false, '');

// Add total amount below the table
$pdf->Ln(-8); // Add a line break with a small vertical space
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(150, 10, 'Total', 0, 0, 'R'); // Label "Total", aligned to the right
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Rp ' . number_format($totalAmount, 2, ',', '.'), 0, 1, 'R'); // Total amount, aligned to the right

// Output PDF directly to the browser
$pdfContent = $pdf->Output('nota.pdf', 'S'); // 'S' returns the PDF as a string

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="nota.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
header('Content-Length: ' . strlen($pdfContent));
ob_clean();
flush();
echo $pdfContent;

// Exit the script
exit;
?>