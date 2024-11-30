<?php
date_default_timezone_set('Asia/Manila'); // Set to your desired timezone
// Start the script with output buffering to prevent accidental output
ob_start();
include '../php/fpdf186/fpdf.php';

$data = file_get_contents("php://input");
$json = json_decode($data, true);

if ($json === null) {
    // Stop output buffering and discard the output
    ob_end_clean();
    echo json_encode(["status" => "error", "message" => "Invalid JSON received"]);
    exit;
}

$transactionDetails = $json['transactionDetails'];
$transactionDate = date('Y-m-d H:i:s'); // Format as 'YYYY-MM-DD HH:MM:SS'

// Initialize FPDF
$width = 100; // width in mm
$height = 220; // height in mm, can be increased as needed

$pdf = new FPDF('P', 'mm', array($width, $height));
$pdf->AddPage();
$pdf->SetFont('Arial', '', 7);

$pageWidth = $pdf->GetPageWidth();
$cellPadding = 10; // Padding on both sides

// Product name cell width (left side)
$productCellWidth = $pageWidth - 60; // Adjust width as needed to leave space for the price
// Price cell width (right side)
$priceCellWidth = 30;

function myHeader($pdfParam, $pageWidthParam, $transact)
{
    // Header
    // Calculate the page width and image width to center the image

    $imageWidth = 55; // Adjust this value based on your image size

    // Centered Image
    $pdfParam->Image('../img/brand-logo-white.png', ($pageWidthParam - $imageWidth) / 2, 10, $imageWidth);
    $pdfParam->Ln(23); // Line break after image

    // Centered Header Text
    $pdfParam->Cell(0, 5, 'www.vivalavida.com', 0, 1, 'C'); // Center-align title text
    $pdfParam->Cell(0, 5, 'San Simon, Dasmrinas City, Cavite', 0, 1, 'C'); // Center-align address
    $pdfParam->Cell(0, 5, "Sold by {$transact['employee_name']}", 0, 1, 'C'); // Center-align additional info
    $pdfParam->Ln(5); // Line break after header text
}

function myHorizontalRule($pdfParam, $pageWidthParam)
{
    // Dotted Horizontal Rule
    $xStart = 10; // starting X position
    $xEnd = $pageWidthParam - 10; // ending X position
    $yPosition = $pdfParam->GetY(); // current Y position

    // Loop to create dots
    for ($x = $xStart; $x < $xEnd; $x += 2) {
        $pdfParam->Cell(1, 0, '-', 0, 0, 'C');
        $pdfParam->Cell(1, 0, ' ', 0, 0, 'C'); // Space between dots
    }

    $pdfParam->Ln(5); // Space after the dotted line
}




myHeader($pdf, $pageWidth, $transactionDetails);

myHorizontalRule($pdf, $pageWidth);

// Cell(width, height, text, border, end line)
// Process JSON and add data to the PDF

// $pdf->Cell($productCellWidth, 7, "Product Name: ", 0, 0, 'L');
// $pdf->Cell($priceCellWidth, 7, "Price: ", 0, 1, 'R');
// $pdf->Cell($productCellWidth, 7, "Quantity: ", 0, 0, 'L');
// $pdf->Ln();
// $pdf->Cell($productCellWidth, 7, "Guitar ID:", 0, 0, 'L');

foreach ($json['guitarOrders'] as $order) {
    $totalPricePerQuantity = $order['price'] * $order['quantity'];
    $pdf->Cell($productCellWidth, 7, "x{$order['quantity']} {$order['name']}", 0, 0, 'L');
    $pdf->Cell($priceCellWidth, 7, "P". number_format((float)$totalPricePerQuantity, 2), 0, 1, 'R');
}


$pdf->Ln(7);
myHorizontalRule($pdf, $pageWidth);


$pdf->Cell($productCellWidth, 7, "Total Amount Due:");
$pdf->Cell($priceCellWidth, 7, "P" .number_format((float)$transactionDetails['amount_due'], 2), 0, 1, 'R');

$pdf->Cell($productCellWidth, 7, "Amount Paid:");
$pdf->Cell($priceCellWidth, 7, "P" .number_format($transactionDetails['amount_paid'], 2), 0, 1, 'R');

$pdf->Cell($productCellWidth, 7, "Change:");
$pdf->Cell($priceCellWidth, 7, "P" .number_format((float)$transactionDetails['sukli'], 2), 0, 1, 'R');


$pdf->Ln(7);
myHorizontalRule($pdf, $pageWidth);

$pdf->Cell($productCellWidth, 7, date('F j, Y g:i A', strtotime($transactionDate)));
$pdf->Ln();
$pdf->Cell($productCellWidth, 7, "Transaction ID: {$transactionDetails['transactionId']}");

$pdf->Ln(12);
myHorizontalRule($pdf, $pageWidth);

$pdf->Ln(6);
$pdf->Cell($productCellWidth, 7, "_________________");
$pdf->Cell(40, 7, "________________", 0, 1, 'R');
$pdf->Cell($productCellWidth, 7, "Emplooyee Signature");
$pdf->Cell(40, 7, "Customer Signature", 0, 1, 'R');


$pdf->Ln(4);
myHorizontalRule($pdf, $pageWidth);

$pdf->Cell(0, 5, 'Thank you for your purchase : )', 0, 1, 'C'); // Center-align address


$pdf->Ln(4);
myHorizontalRule($pdf, $pageWidth);

$pdf->SetFont('Arial', '', 6);
$pdf->MultiCell(78, 3, "Return Policy: Request for unit replacement that meets our standard & policy are only accepted within the first 14 days of purchase.", 0, 'L');

// Output the PDF directly to the browser
ob_end_clean(); // Clear any previous output
$pdf->Output(); // Send the PDF to the browser
exit; // Stop script execution to prevent further output
