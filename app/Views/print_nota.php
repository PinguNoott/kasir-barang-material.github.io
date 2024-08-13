<!DOCTYPE html>
<html>
<head>
    <title>Print Nota</title>
</head>
<body>

<?php
// Include TCPDF library
require_once(ROOTPATH . 'Vendor/autoload.php'); // Adjust the path as necessary

// Create a new TCPDF instance
$pdf = new TCPDF('P', 'mm', 'A6', true, 'UTF-8', false); // Adjust page size for receipt
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Nota');
$pdf->SetSubject('Nota');

// Add a page
$pdf->AddPage();

// Set margins: left, top, right
$pdf->SetMargins(7, 10, 7); // Set margins to 7mm left, 10mm top, and 7mm right

// Set font
$pdf->SetFont('helvetica', '', 10);

// Fetch the website icon and name from the setting (ensure these are available and properly fetched)
$websiteIcon = isset($setting->tab_icon) ? $setting->tab_icon : 'default-icon.png'; // Fallback value
$websiteName = isset($setting->judul_website) ? $setting->judul_website : 'Default Website'; // Fallback value

// Construct the image path
$imagePath = FCPATH . 'images/' . $websiteIcon;

// Get page dimensions
$pageWidth = $pdf->getPageWidth();
$pageHeight = $pdf->getPageHeight();

// Get image dimensions
$imageSize = getimagesize($imagePath);
$imageWidth = $imageSize[0];
$imageHeight = $imageSize[1];

// Calculate image size and position to fit within the page
$maxWidth = $pageWidth - 14; // Adjust for left and right margins
$maxHeight = $pageHeight - 20; // Adjust for top and bottom margins

$imageScale = min($maxWidth / $imageWidth, $maxHeight / $imageHeight);

$scaledWidth = $imageWidth * $imageScale;
$scaledHeight = $imageHeight * $imageScale;

$xPosition = ($pageWidth - $scaledWidth) / 2;
$yPosition = ($pageHeight - $scaledHeight) / 2;

// Set opacity (0.3 for 30%)
$pdf->SetAlpha(0.3);

// Add the image to cover the full page
$pdf->Image($imagePath, $xPosition, $yPosition, $scaledWidth, $scaledHeight, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);

// Reset alpha to default (no opacity) for the rest of the content
$pdf->SetAlpha(1);

$kode_keranjang = isset($transaksi->kode_keranjang) ? $transaksi->kode_keranjang : 'CPP-123';
$no_transaksi = isset($transaksi->no_transaksi) ? $transaksi->no_transaksi : 'CPP-123';
// Prepare HTML content with inline styles
$html = '<div style="font-family: Arial, sans-serif; font-size: 12px; text-align: center; margin-bottom: 2px;">'; // Add margin-bottom to create space
$html .= '<div style="margin-bottom: 2px; display: flex; flex-direction: column; align-items: center;">'; // Add margin-bottom here as well
$html .= '<h1>' . htmlspecialchars($websiteName, ENT_QUOTES, 'UTF-8') . '</h1>';
$html .= '<p>' . date('D d/m/Y H:i:s') . '</p>';
$html .= '</div>';
$html .= '<table style="width: 100%; border-collapse: collapse;">';

// Add kode_keranjang
$html .= '<tr><td colspan="2" style="text-align: left; padding: 5px;">Kasir : '.session()->get('nama'). '</td></tr>';
$html .= '<tr><td colspan="2" style="text-align: left; padding: 5px;">No Transaksi : '. htmlspecialchars($no_transaksi, ENT_QUOTES, 'UTF-8') . '</td></tr>';
$html .= '<tr><td colspan="2" style="text-align: left; padding: 5px;">Kode Keranjang : '. htmlspecialchars($kode_keranjang, ENT_QUOTES, 'UTF-8') . '</td></tr>';

// Add items
$totalAmount = 0;
foreach ($satu as $item) {
    $itemTotal = $item->quantity * $item->harga_jual;
    $html .= '<tr>';
    $html .= '<td style="text-align: left; padding: 5px;">' . htmlspecialchars($item->nama_barang, ENT_QUOTES, 'UTF-8') . ' - ' . $item->quantity . '</td>';
    $html .= '<td style="text-align: right; padding: 5px;">Rp ' . number_format($itemTotal, 0, ',', '.') . '</td>';
    $html .= '</tr>';
    $totalAmount += $itemTotal;
}

// Add a horizontal rule before the total amount with top margin
$html .= '<tr><td colspan="2" style="padding: 5px;"><hr style="border: 1px solid black; margin: 10px 0 5px 0;"></td></tr>';

// Add total amount
$html .= '<tr>';
$html .= '<td colspan="2" style="font-weight: bold; text-align: right; padding: 5px;">Total: Rp ' . number_format($totalAmount, 0, ',', '.') . '</td>';
$html .= '</tr>';
$html .= '</table>';
$html .= '</div>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

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

</body>
</html>
