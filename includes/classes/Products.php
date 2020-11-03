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

//    public function getAllbrands(){
//        $prep_stat = $this->con->prepare("SELECT * FROM brands ");
//        $prep_stat->execute() or die($this->con->error);
//        return  $prep_stat->get_result()->fetch_all(MYSQLI_ASSOC);
//
//    }

}
