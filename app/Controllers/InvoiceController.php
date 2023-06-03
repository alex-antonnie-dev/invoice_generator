<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

class InvoiceController extends BaseController
{

    public function create()
    {
        return view('invoice/create_invoice');
    }

    public function processForm()
    {
        $name       = $this->request->getPost('itemName');
        $quantity   = $this->request->getPost('quantity');
        $unitPrice  = $this->request->getPost('unitPrice');
        $tax        = $this->request->getPost('tax');

        $discountPercentage = $this->request->getPost('discountPercentage');


        // echo '<pre>';print_r($_POST);
        $data = ['itemName' => $name, 'quantity' => $quantity, 'unitPrice' => $unitPrice, 'tax' => $tax, 'discountPercentage' => $discountPercentage];
        $this->generatePdf($data);
    }

    public function generatePdf($data)
    {
        $grandTotal = 0;
        $dompdf = new Dompdf();

        // Generate PDF content
        $html = '<html><body><h1>Invoice</h1><table><thead><tr><th>Slno</th><th>Item name</th><th>Quantity</th>';
        $html .= '<th>Price</th><th>Tax</th><th>Total</th></tr></thead><tbody>';
        if(!empty($data['itemName']))
        {
            $slno = 0;
            foreach($data['itemName'] as $key => $val)
            {
                $slno++;
                $html .= '<tr>';
                $html .= '<td>'.$slno.'</td>';
                $html .= '<td>'.$data['itemName'][$key].'</td>';
                $html .= '<td>'.$data['quantity'][$key].'</td>';
                $html .= '<td>'.$data['unitPrice'][$key].'</td>';
                $html .= '<td>'.$data['tax'][$key].'</td>';
                $total = $data['quantity'][$key] * $data['unitPrice'][$key];
                $total = $total + ($total * $data['tax'][$key]) / 100;
                $html .= '<td>'.$total.'</td>';
                $html .= '</tr>';
                $grandTotal += $total;
            }
        }
        $html .= '</tbody></table><br/><br/><br/>';

        $discount = $data['discountPercentage'];
        $finalTotal = $grandTotal - (($grandTotal * $discount) /100);

        $html .= '<table><tbody><tr><td>Subtotal</td><td>'.$grandTotal.'</td></tr>';
        $html .= '<tr><td>Discount Percentage</td><td>'.$discount.'</td></tr>';
        $html .= '<tr><td><b>GrandTotal</b></td><td>'.$finalTotal.'</td></tr>';
        $html .= '</tbody></table>';
        $html .= '</html>';
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Output the generated PDF
        // $dompdf->stream('sample.pdf', ['Attachment' => false]);

        // Get the PDF content
    $pdfContent = $dompdf->output();

    // Set the file name
    $filename = 'invoice.pdf';

    // Set the headers for file download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . strlen($pdfContent));

    // Output the PDF content
    echo $pdfContent;
    exit;
    }
}
