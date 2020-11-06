<?php

class Products {

    private $con;
    public $errors = [];

    public function __construct() {
        include_once 'Database.php';
        $db = new Database();
        $this->con = $db->connect();
    }

    public function addProduct($category, $brand, $name, $price, $stock, $date){

        $prep_stat = $this->con->prepare('INSERT INTO
                                                            products(
                                                            category_id,
                                                            brand_id,
                                                            product_name,
                                                            product_price,
                                                            product_stock,
                                                            product_added_date) 
                                                        VALUES (?,?,?,?,?,?)
                                                        ');
        $prep_stat->bind_param('iisiis', $category,$brand,$name,$price,$stock,$date);
        $result = $prep_stat->execute() or die($this->con->error);
        if ($result){
            return 'Product created';
        }else{
            return false;
        }

    }

    public function getSingleProduct($product_id){

        $prep_stat = $this->con->prepare("SELECT * FROM products WHERE id=?");
        $prep_stat->bind_param('i', $product_id);
        $prep_stat->execute()or die($this->con->error);

        return  $prep_stat->get_result()->fetch_assoc();

    }

    public function getAllProducts(){
        $prep_stat = $this->con->prepare("SELECT * FROM products");
        $prep_stat->execute() or die($this->con->error);
        return  $prep_stat->get_result()->fetch_all(MYSQLI_ASSOC);

    }

    function updateProduct($product_id, $category, $brand, $name, $price, $stock, $date){

        $prep_stat = $this->con->prepare("UPDATE products SET 
                                                            category_id=?,
                                                            brand_id=?,
                                                            product_name=?,
                                                            product_price=?,
                                                            product_stock=?,
                                                            product_added_date=?
                                                         WHERE id=?");
        $prep_stat->bind_param('iisiisi', $category, $brand, $name, $price, $stock, $date,$product_id);
        if ($prep_stat->execute()){
            return 'Product updated successfully.';
        }else{
            die($this->con->error);
        }

    }

    public function deleteProduct($product_id){

        $prep_stat = $this->con->prepare("DELETE FROM products WHERE id=?");
        $prep_stat->bind_param('i', $product_id);

        if ($prep_stat->execute()){
            return 'Product deleted successfully';
        }else{
            die($this->con->error);
        }

    }



}
