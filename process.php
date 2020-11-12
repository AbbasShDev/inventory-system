<?php
session_start();
require_once 'includes/classes/Category.php';
require_once 'includes/classes/Brands.php';
require_once 'includes/classes/Products.php';
require_once 'includes/classes/Invoices.php';
require_once 'includes/classes/Users.php';
require_once 'includes/classes/Uploader.php';
require_once 'includes/config/app.php';

if (!isset($_SESSION['user_id'])){
    header("location: $config[app_url]");
    die();
}


if ($_SESSION['user_role'] != 'Admin'){
    header('location:dashboard');
    die();
}

$errors = [];

$product   = new Products();
$category = new Category();
$brand = new Brands();
$invoice = new Invoices();
$user = new Users();

//Get all parent categories in select
if (isset($_POST['get_parents_categories'])){

    $categories = $category->getAllCategories(0);?>
    <option value="0" selected>Parent</option>
    <?php foreach ($categories as $cat):?>
        <option value="<?php echo $cat['id']?>" >
            <?php echo $cat['category_name']?>
        </option>
    <?php endforeach;
}

//Get all categories in select
if (isset($_POST['get_all_categories'])){
    $categories = $category->getAllCategories();?>
    <option value="0" selected disabled>Select Category</option>
    <?php foreach ($categories as $cat):
        if ($cat['parent_category'] == 0):?>
            <option value="<?php echo $cat['id']?>" >
                <?php echo $cat['category_name']; ?>
            </option>
            <?php foreach ($categories as $BabyCat):
                if ($BabyCat['parent_category'] == $cat['id']):?>
                    <option value="<?php echo $BabyCat['id']?>" >
                        &nbsp;&nbsp;- <?php echo $BabyCat['category_name']?>
                    </option>
                <?php endif; endforeach;
        endif; endforeach;
}

//Get all brands in select
if (isset($_POST['get_all_brands'])){
    $brands = $brand->getAllbrands();?>
    <option value="" selected disabled>Select Brand</option>
    <?php foreach ($brands as $br):?>
        <option value="<?php echo $br['id']?>" >
            <?php echo $br['brand_name']?>
        </option>
    <?php endforeach;
}

//add category
if (isset($_POST['category_name']) && isset($_POST['parent_category'])){

    $result = $category->addCategory($_POST['parent_category'], $_POST['category_name']);
    echo $result;
}

//add brand
if (isset($_POST['brand_name'])){

    $result = $brand->addBrand($_POST['brand_name']);
    echo $result;
}

//add product
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
    if ($result == 'Brand is already exist.'){
        $_SESSION['error_message'] = $result;
        echo $result;
    }elseif ($result == 'Brand updated successfully.'){
        $_SESSION['notify_message'] = $result;
        echo $result;
    }else {
        $result;
    }
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

//Delete invoice
if (isset($_POST['delete_invoice_id'])){

    $result     = $invoice->deleteInvoice($_POST['delete_invoice_id']);
    $_SESSION['notify_message'] = $result;
    echo $result;
}
//Update product (get info)
if (isset($_POST['get_user_info'])){
    $result     = $user->getUser($_POST['get_user_info']);
    echo json_encode($result);
}
//Update user
if (isset($_POST['edit_user_id']) && isset($_POST['edit_username'])){

    $userID         = $_POST['edit_user_id'];
    $username       = $_POST['edit_username'];
    $email          = $_POST['email'];
    $password       = $_POST['password'];
    $password_conf  = $_POST['password_conf'];
    $user_role      = $_POST['select_Role'];

    if (empty($username)){array_push($errors, 'Name is required.');}
    if (empty($email)){array_push($errors, 'Email is required.');}
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){array_push($errors, 'You mast enter valid email');}
    if (empty($user_role)){array_push($errors, 'User Role confirmation is required.');}



    if (!empty($errors)){

        $errors_result = '';
        foreach ($errors as $error ){
            $errors_result .= "<p class='m-0'>- $error</p>";
        }

        $msg = '<div class=" alert alert-danger alert-dismissible col-md-10 mx-auto">
                        '.$errors_result.'
                    </div>';
        echo $msg;
    }



    if (empty($errors) && empty($password)){

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0){

            $allowedTypes = [
                'jpg' =>'image/jpeg',
                'png' =>'image/png',
                'gif' =>'image/gif'
            ];

            $upload = new Uploader('uploads/avatars', $allowedTypes, $config['root_dir']);
            $upload->file = $_FILES['avatar'];
            $errors = $upload->upload();

            $filePath = $upload->filePath;
            if (!count($errors) && !empty($avatar)){
                unlink($config['root_dir'].$avatar);

            }

            if (!count($errors) ){
                $errors = $user->updateUserImg($userID,  $filePath);
            }

            if (!empty($errors)){

                $errors_result = '';
                foreach ($errors as $error ){
                    $errors_result .= "<p class='m-0'>- $error</p>";
                }

                $msg = '<div class=" alert alert-danger alert-dismissible col-md-10 mx-auto">
                        '.$errors_result.'
                    </div>';
                echo $msg;
            }

        }


        if (empty($errors)){
            $result = $user->updateUsernameEmailRole($userID, $username, $email, $user_role);

            if ($result == 'User updated Successfully'){
                $_SESSION['notify_message'] = $result;
                echo $result;
            }else{
                $msg = '<div class=" alert alert-danger alert-dismissible col-md-10 mx-auto">
                        '.'- '.$result.'
                    </div>';
                echo $msg;
            }
        }

    }elseif (empty($errors) && !empty($password)){

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0){

            $allowedTypes = [
                'jpg' =>'image/jpeg',
                'png' =>'image/png',
                'gif' =>'image/gif'
            ];

            $upload = new Uploader('uploads/avatars', $allowedTypes, $config['root_dir']);
            $upload->file = $_FILES['avatar'];
            $errors = $upload->upload();

            $filePath = $upload->filePath;
            if (!count($errors) && !empty($avatar)){
                unlink($config['root_dir'].$avatar);

            }

            if (!count($errors) ){
                $errors = $user->updateUserImg($userID,  $filePath);
            }

        }

        if (strlen($password) < 6){array_push($errors, 'Password must be greater than 6.');}
        if (empty($password_conf)){array_push($errors, 'Password confirmation is required.');}

        if ($password != $password_conf){array_push($errors, "Passwords don't match.");}


        if (!empty($errors)){

            $errors_result = '';
            foreach ($errors as $error ){
                $errors_result .= "<p class='m-0'>- $error</p>";
            }

            $msg = '<div class=" alert alert-danger alert-dismissible col-md-10 mx-auto">
                        '.$errors_result.'
                    </div>';
            echo $msg;
        }

        if (empty($errors)){

            $result = $user->updateAllUserInfo($userID,$username, $email, $user_role, $password);

            if ($result == 'User updated Successfully'){
                $_SESSION['notify_message'] = $result;
                echo $result;
            }else{
                $msg = '<div class=" alert alert-danger alert-dismissible col-md-10 mx-auto">
                        '.'- '.$result.'
                    </div>';
                echo $msg;
            }

        }


    }




}

//Delete user
if (isset($_POST['delete_user_id'])){

    $result     = $user->deleteUser($_POST['delete_user_id']);
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
    if (isset($_POST['pid'])){$arr_pid = $_POST['pid'];}
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

    //From Validation
    if (empty($customer_name)){$errors[] = 'Name is required';}
    if ($sub_total < 0 ){$errors[] = 'Sub total can not be less than 0';}
    if (empty($sub_total) & $sub_total != '0'){$errors[] = 'Sub total is required';}
    if ($gst < 0){$errors[] = 'GST can not be less than 0';}
    if (empty($gst) & $gst != '0'){$errors[] = 'GST is required';}
    if ($discount < 0){$errors[] = 'Discount can not be less than 0';}
    if (empty($discount) & $discount != '0'){$errors[] = 'Discount is required OR enter 0';}
    if ($net_total < 0){$errors[] = 'Net total can not be less than 0';}
    if (empty($net_total) & $net_total != '0'){$errors[] = 'Net total is required';}
    if ($paid < 0){$errors[] = 'Paid can not be less than 0';}
    if (empty($paid) & $paid != '0'){$errors[] = 'Paid is required OR enter 0';}
    if ($due < 0){$errors[] = 'Due can not be less than 0';}
    if (empty($due) & $due != '0'){$errors[] = 'Due is required OR enter 0';}

    foreach ($arr_tqty as $tqty){
        if (empty($tqty)){
            $errors[] = 'Total Quantity is required';
            break;
        }

    }
    foreach ($arr_qty as $qty){
        if (empty($qty)){
            $errors[] = 'Quantity is required';
            break;
        }
    }
    foreach ($arr_price as $price){
        if (empty($price)){
            $errors[] = 'Price is required';
            break;
        }

    }
    foreach ($arr_pro_name as $pro_name){
        if (empty($pro_name)){
            $errors[] = 'Product name is required';
            break;
        }

    }

    if (!empty($errors)){

        $errors_result = '';
        foreach ($errors as $error ){
            $errors_result .= "<p class='m-0'>- $error</p>";
        }

        $msg = '<div class=" alert alert-danger alert-dismissible col-md-10 mx-auto">
                        '.$errors_result.'
                    </div>';
        echo $msg;
    }

    if (empty($errors)){

        $result = $invoice->storeInvoice(
            $order_date,
            $customer_name,
            $arr_pid,
            $arr_tqty,
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

        if (is_array($result)){

            $msg = '<div class=" alert alert-success alert-dismissible col-md-10 mx-auto">
                        <p class="m-0">'.$result['massage'].'</p>
                            <div class="m-0">
                                View invoice
                                <form action="view_invoice" method="post" target="_blank" style="display: inline-block">
                                    <input type="hidden" name="invo_id" value="'.$result['invoice_id'].'">
                                    <input type="submit" value="here" class="alert-link p-0 border-0" style="background: none; text-decoration: underline">
                                </form>
                            </div>
                    </div>';

            echo $msg;
        }else{
            $msg = '<div class=" alert alert-danger alert-dismissible col-md-10 mx-auto">
                        <p class="m-0">'.$result.'</p>
                    </div>';
            echo $msg;
        }

    }
}

//add user
if (isset($_POST['username']) && isset($_POST['email'])){

    $username       = $_POST['username'];
    $email          = $_POST['email'];
    $password       = $_POST['password'];
    $password_conf  = $_POST['password_conf'];
    $user_role      = $_POST['select_Role'];

    if (empty($username)){array_push($errors, 'Name is required.');}
    if (empty($email)){array_push($errors, 'Email is required.');}
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){array_push($errors, 'You mast enter valid email');}
    if (empty($password)){array_push($errors, 'Password is required.');}
    if (strlen($password) < 6){array_push($errors, 'Password must be greater than 6.');}
    if (empty($password_conf)){array_push($errors, 'Password confirmation is required.');}
    if (empty($user_role)){array_push($errors, 'User Role confirmation is required.');}

    if ($password != $password_conf){array_push($errors, "Passwords don't match.");}

    if (!empty($errors)){

        $errors_result = '';
        foreach ($errors as $error ){
            $errors_result .= "<p class='m-0'>- $error</p>";
        }

        $msg = '<div class=" alert alert-danger alert-dismissible col-md-10 mx-auto">
                        '.$errors_result.'
                    </div>';
        echo $msg;
    }

    if (empty($errors)){

        $result = $user->addUserByAdmin($username, $email, $password, $user_role);

        if ($result == 'User created Successfully'){
            $_SESSION['notify_message'] = $result;
            echo $result;
        }else{
            $msg = '<div class=" alert alert-danger alert-dismissible col-md-10 mx-auto">
                        '.'- '.$result.'
                    </div>';
            echo $msg;
        }
    }
}
