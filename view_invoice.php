<?php
session_start();

require_once 'includes/classes/Invoices.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once 'includes/config/app.php';

if (!isset($_SESSION['user_id'])){
    header("location: $config[app_url]");
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['invo_id']) && is_numeric($_POST['invo_id'])){

    $invoice_id =  intval($_POST['invo_id']);
    $invoice = new Invoices();

    if ($invoice->existInvoice($invoice_id)){

        $invoice_details = $invoice->getSingleInvoice($invoice_id);
        $invoice_items = $invoice->getSingleInvoiceDetails($invoice_id);


        try {

            $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);

            $mpdf->WriteHTML('<h2 style="text-align: center">Inventory Management System </h2>');
            $mpdf->WriteHTML('<br>');
            $mpdf->WriteHTML('<div style="width: 100%; padding-bottom: 10px"><div align="left" style="width: 20%;float: left;">Order date</div><div>: '.$invoice_details['order_date'].'</div></div>');
            $mpdf->WriteHTML('<div style="width: 100%; padding-bottom: 10px"><div align="left" style="width: 20%;float: left;">Customer Name</div><div>:'.$invoice_details['customer_name'].'</div></div>');
            $mpdf->WriteHTML('<br>');
            $mpdf->WriteHTML('<br>');
            $mpdf->WriteHTML('<table style="border-collapse: collapse; border: 1px solid">');
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<th style="padding: 5px 0px; border-right: 1px solid" width="10%">#</th>');
            $mpdf->WriteHTML('<th style="padding: 5px 0px; border-right: 1px solid"  width="90%">Product Name</th>');
            $mpdf->WriteHTML('<th style="padding: 5px 0px; border-right: 1px solid"  width="20%">Quantity</th>');
            $mpdf->WriteHTML('<th style="padding: 5px 0px; border-right: 1px solid"  width="10%">Price</th>');
            $mpdf->WriteHTML('<th style="padding: 5px 0px;" width="10%">Total($)</th>');
            $mpdf->WriteHTML('</tr>');

            $n = 0;
            foreach ($invoice_items as $item){

            $total_item_price = $item['qty'] * $item['price'];
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td style="text-align: center; padding: 5px 0px; border-right: 1px solid; border-top: 1px solid" width="10%">'.++$n.'</td>');
            $mpdf->WriteHTML('<td style="text-align: left; padding: 5px ; border-right: 1px solid; border-top: 1px solid"  width="90%">'.$item['product_name'].'</td>');
            $mpdf->WriteHTML('<td style="text-align: center; padding: 5px 0px; border-right: 1px solid; border-top: 1px solid"  width="10%">'.$item['qty'].'</td>');
            $mpdf->WriteHTML('<td style="text-align: center; padding: 5px 0px; border-right: 1px solid; border-top: 1px solid"  width="20%">'.$item['price'].'</td>');
            $mpdf->WriteHTML('<td style="text-align: center; padding: 5px 0px; border-top: 1px solid" width="10%">'.$total_item_price.'</td>');
            $mpdf->WriteHTML('</tr>');

            }
            $mpdf->WriteHTML('</table>');
            $mpdf->WriteHTML('<br>');
            $mpdf->WriteHTML('<br>');
            $mpdf->WriteHTML('<br>');

            $mpdf->WriteHTML('<div style="width: 100%; padding-bottom: 10px"><div align="left" style="width: 20%;float: left;">Sub total</div><div>: $'.$invoice_details['sub_total'].'</div></div>');
            $mpdf->WriteHTML('<div style="width: 100%; padding-bottom: 10px"><div align="left" style="width: 20%;float: left;">GST tax</div><div>: $'.$invoice_details['gst'].'</div></div>');
            $mpdf->WriteHTML('<div style="width: 100%; padding-bottom: 10px"><div align="left" style="width: 20%;float: left;">Discount</div><div>: $'.$invoice_details['discount'].'</div></div>');
            $mpdf->WriteHTML('<div style="width: 100%; padding-bottom: 10px"><div align="left" style="width: 20%;float: left;">Net total</div><div>: $'.$invoice_details['net_total'].'</div></div>');
            $mpdf->WriteHTML('<div style="width: 100%; padding-bottom: 10px"><div align="left" style="width: 20%;float: left;">Paid</div><div>: $'.$invoice_details['paid'].'</div></div>');
            $mpdf->WriteHTML('<div style="width: 100%; padding-bottom: 10px"><div align="left" style="width: 20%;float: left;">Due</div><div>: $'.$invoice_details['due'].'</div></div>');
            $mpdf->WriteHTML('<div style="width: 100%; padding-bottom: 10px"><div align="left" style="width: 20%;float: left;">Payment method</div><div>: '.$invoice_details['payment_type'].'</div></div>');
            $mpdf->WriteHTML('<br><br><br><br><br>');
            $mpdf->WriteHTML('<div align="right" style="width: 100%; padding-right: 30px">Signature</div>');

            $mpdf->SetFooter('<p align="left">Thanks for using Inventory Management System</p>');

            $filedir = 'uploads/invoices/';
            $filename = $invoice_details['id'].'_'.date('Y-m-d').'.pdf';

            $invoice->updateInvoicePDF($filedir.$filename, $invoice_details['id']);
            //Saves file on the server as 'filename.pdf'
            $mpdf->Output($filedir.$filename, F);

            if (isset($_POST['download']) && $_POST['download'] == 'download'){
                //Download file
                $mpdf->Output($filename, D);
            }else{
                //open file to view
                $mpdf->Output($filename, I);
            }

        } catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception name used for catch
            // Process the exception, log, print etc.
            die('Something went wrong');
        }

    }else{
        die('Access Denied');
    }
}else{
    die('Access Denied');
}