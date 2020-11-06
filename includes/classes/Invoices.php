<?php

class Invoices {

    private $con;
    public $errors = [];

    public function __construct() {
        include_once 'Database.php';
        $db = new Database();
        $this->con = $db->connect();
    }

    public function storeInvoice($order_date, $customer_name, $arr_qty, $arr_price, $arr_pro_name, $sub_total, $gst, $discount, $net_total, $paid, $due, $payment_type){
        $prep_stat = $this->con->prepare('INSERT INTO invoice (customer_name, order_date, sub_total, gst, discount, net_total, paid, due, payment_type) 
                                                VALUES (?,?,?,?,?,?,?,?,?)');
        $prep_stat->bind_param('ssdddddds', $customer_name, $order_date, $sub_total, $gst, $discount, $net_total, $paid, $due, $payment_type);

        if ($prep_stat->execute()){
            $invoice_id = $prep_stat->insert_id;
            for ($i = 0; $i < count($arr_price); $i++){
                $insert_product = $this->con->prepare('INSERT INTO invoice_details (invoice_id, product_name, price, qty) 
                                                    VALUES (?,?,?,?)');
                $insert_product->bind_param('isdd', $invoice_id, $arr_pro_name[$i], $arr_price[$i], $arr_qty[$i]);
                $insert_product->execute() or die($this->con->error);
            }
                return 'Category created';
        }else{
            return $this->con->error;
        }
    }

}