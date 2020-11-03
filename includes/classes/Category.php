<?php

class Category {

    private $con;
    public $errors = [];

    public function __construct() {
        include_once 'Database.php';
        $db = new Database();
        $this->con = $db->connect();
    }

    public function addCategory($parent_ID, $name){

        $prep_stat = $this->con->prepare('INSERT INTO categories  (parent_category, category_name) VALUES (?,?)');
        $prep_stat->bind_param('is', $parent_ID, $name);
        $result = $prep_stat->execute() or die($this->con->error);
        if ($result){
            return 'Category created';
        }else{
            return false;
        }

    }

    public function getAllCategories($parent = 1){

        if ($parent == 1){
            $where_stat = '';
        }else{
            $where_stat = 'WHERE parent_category=0';
        }
            $prep_stat = $this->con->prepare("SELECT * FROM categories $where_stat");
            $prep_stat->execute() or die($this->con->error);
            return  $prep_stat->get_result()->fetch_all(MYSQLI_ASSOC);

    }

}
