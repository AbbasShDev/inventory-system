<?php
session_start();
require_once 'includes/classes/Category.php';
require_once 'includes/classes/Brands.php';
require_once 'includes/classes/Products.php';
require_once 'includes/classes/Invoices.php';

$product   = new Products();
$category = new Category();
$brand = new Brands();
$invoice = new Invoices();

if (isset($_POST['category_name']) & isset($_POST['parent_category'])){

    $result = $category->addCategory($_POST['parent_category'], $_POST['category_name']);
    echo $result;
}

if (isset($_POST['brand_name'])){

    $result = $brand->addBrand($_POST['brand_name']);
    echo $result;
}

if (isset($_POST['product_name']) & isset($_POST['product_price'])){

    $result = $product->addProduct(
        $_POST['select_category'],
        $_POST['select_brand'],
        $_POST['product_name'],
        $_POST['product_price'],
        $_POST['product_quantity'],
        $_POST['date']
        );
    echo $result;
}

if (isset($_POST['delete_category_id'])){

    $result     = $category->deleteCategory($_POST['delete_category_id']);
    if ($result == 'Category deleted successfully'){
        $_SESSION['notify_message'] = 'Category deleted successfully';
    }elseif ($result == 'Sorry this category is a parent of other categories'){
        $_SESSION['error_message'] = 'Sorry this category is a parent of other categories';
    }
    echo $result;
}

if (isset($_POST['get_category_id'])){

    $result     = $category->getSingleCategory($_POST['get_category_id']);
    echo json_encode($result);
}

if (isset($_POST['edit_category_name'])){

    $result = $category->updateCategory(
        $_POST['edit_parent_category'],
        $_POST['edit_category_name'],
        $_POST['edit_category_id']);

        $_SESSION['notify_message'] = $result;

    echo $result;

}

//Update brand (get info)
if (isset($_POST['get_brand_id'])){

    $result     = $brand->getSingleBrand($_POST['get_brand_id']);
    echo json_encode($result);
}
//Update brand
if (isset($_POST['edit_brand_name'])){

    $result = $brand->updateBrand($_POST['edit_brand_id'], $_POST['edit_brand_name']);
    $_SESSION['notify_message'] = $result;

    echo $result;
}

//Delete brand
if (isset($_POST['delete_brand_id'])){

    $result     = $brand->deleteBrand($_POST['delete_brand_id']);
    $_SESSION['notify_message'] = $result;
    echo $result;
}

//Update product (get info)
if (isset($_POST['get_product_info'])){
    $result     = $product->getSingleProduct($_POST['get_product_info']);
    echo json_encode($result);
}
//Update product
if (isset($_POST['edit_product_id']) & isset($_POST['edit_product_name'])){

    $result     = $product->updateProduct(
        $_POST['edit_product_id'],
        $_POST['select_category'],
        $_POST['select_brand'],
        $_POST['edit_product_name'],
        $_POST['product_price'],
        $_POST['product_quantity'],
        $_POST['date']
    );

    $_SESSION['notify_message'] = $result;
    echo $result;
}

//Delete product
if (isset($_POST['delete_product_id'])){

    $result     = $product->deleteProduct($_POST['delete_product_id']);
    $_SESSION['notify_message'] = $result;
    echo $result;
}

//---------------------------- Order -----------------------------

//get New Order Item
if (isset($_POST['getNewOrderItem'])){
    $products = $product->getAllProducts();

    $result = '';
    $result .= '<tr>
                <td><b class="number"></b></td>
                <td>
                <select name="pid[]" class="form-control form-control-sm pid" style="max-width: 240px !important;">
                <option value="" selected disabled>Choose product</option>';
    foreach ($products as $product){
    $result .= '<option value="'.$product['id'].'">'.$product['product_name'].'</option>';}
    $result .= '</select>
                </td>
                <td><input type="text" name="tqty[]" class="form-control form-control-sm tqty" readonly></td>
                <td><input type="text" name="qty[]" class="form-control form-control-sm qty"></td>
                <td><input type="text" name="price[]" class="form-control form-control-sm price" readonly></td>
                <td class="d-none"><input type="hidden" name="pro_name[]" class="form-control form-control-sm pro_name"></td>
                <td>$<span class="total_item_price">0</span></td>
               
                </tr>';
    echo $result;;
}

//get item price quantity
if (isset($_POST['get_item_price_quantity'])){
    $result     = $product->getSingleProduct($_POST['get_item_price_quantity']);
    echo json_encode($result);
}

if (isset($_POST['customer_name']) & isset($_POST['order_date'])){

    $order_date     = $_POST['order_date'];
    $customer_name  = $_POST['customer_name'];
    $arr_pid        = $_POST['pid'];
    $arr_tqty       = $_POST['tqty'];
    $arr_qty        = $_POST['qty'];
    $arr_price      = $_POST['price'];
    $arr_pro_name   = $_POST['pro_name'];
    $sub_total      = $_POST['sub_total'];
    $gst            = $_POST['gst'];
    $discount       = $_POST['discount'];
    $net_total      = $_POST['net_total'];
    $paid           = $_POST['paid'];
    $due            = $_POST['due'];
    $payment_type   = $_POST['payment_type'];


    $result = $invoice->storeInvoice(
        $order_date,
        $customer_name,
        $arr_qty,
        $arr_price,
        $arr_pro_name,
        $sub_total,
        $gst,
        $discount,
        $net_total,
        $paid,
        $due,
        $payment_type
    );

    if ($result == 'Category created'){
        $_SESSION['notify_message'] = $result;
        echo $result;
    }else{
        $_SESSION['error_message'] = 'Something went wrong while making order, try again.';
        echo $result;
    }


}

