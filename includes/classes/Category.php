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

    public function getSingleCategory($category_id){


        $prep_stat = $this->con->prepare("SELECT * FROM categories WHERE id=?");
        $prep_stat->bind_param('i', $category_id);
        $prep_stat->execute()or die($this->con->error);

        return  $prep_stat->get_result()->fetch_assoc();

    }

    function updateCategory($parent_category, $category_name, $category_id){
        $prep_stat = $this->con->prepare("SELECT * FROM categories WHERE parent_category=?");
        $prep_stat->bind_param('i', $category_id);
        $prep_stat->execute();
        $result = $prep_stat->get_result();


        if ($result->num_rows > 1){

                $prep_stat = $this->con->prepare("UPDATE categories SET category_name=? WHERE id=?");
                $prep_stat->bind_param('si',$category_name,$category_id);
                if ($prep_stat->execute()){
                    if ($parent_category != 0){
                        return "Name updated successfully, but you can't update patent because it is a parent category.";
                    }else{
                        return 'Category updated successfully.';
                    }
                }else{
                    die($this->con->error);
                }

        }else{
            $prep_stat = $this->con->prepare("UPDATE categories SET parent_category=?, category_name=? WHERE id=?");
            $prep_stat->bind_param('isi', $parent_category,$category_name,$category_id);
            if ($prep_stat->execute()){
                return 'Category updated successfully.';
            }else{
                die($this->con->error);
            }
        }

    }


    public function deleteCategory($category_id){
        $prep_stat = $this->con->prepare("SELECT * FROM categories WHERE parent_category=?");
        $prep_stat->bind_param('i', $category_id);
        $prep_stat->execute()or die($this->con->error);
        $result = $prep_stat->get_result();

        if ($result->num_rows > 1){
            return 'Sorry this category is a parent of other categories';
        }else{
            $prep_stat = $this->con->prepare("DELETE FROM categories WHERE id=?");
            $prep_stat->bind_param('i', $category_id);

            if ($prep_stat->execute()){
                return 'Category deleted successfully';
            }else{
                die($this->con->error);
            }
        }
    }

}