<?php

class Brands {

    private $con;
    public $errors = [];

    public function __construct() {
        include_once 'Database.php';
        $db = new Database();
        $this->con = $db->connect();
    }

    private function brandExist($name) {

        $prep_stat = $this->con->prepare('SELECT id FROM brands WHERE brand_name=?');
        $prep_stat->bind_param('s', $name);
        $prep_stat->execute() or die($this->con->error);
        $result = $prep_stat->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addBrand($brand_name){

        if ($this->brandExist($brand_name)){
            return 'Brand is already exist.';
        }else{
            $prep_stat = $this->con->prepare('INSERT INTO brands (brand_name) VALUES (?)');
            $prep_stat->bind_param('s', $brand_name);
            $result = $prep_stat->execute() or die($this->con->error);
            if ($result){
                return 'Brand created';
            }else{
                return false;
            }
        }


    }

    public function getAllbrands(){
        $prep_stat = $this->con->prepare("SELECT * FROM brands ");
        $prep_stat->execute() or die($this->con->error);
        return  $prep_stat->get_result()->fetch_all(MYSQLI_ASSOC);

    }

    public function getSingleBrand($brand_id){

        $prep_stat = $this->con->prepare("SELECT * FROM brands WHERE id=?");
        $prep_stat->bind_param('i', $brand_id);
        $prep_stat->execute() or die($this->con->error) ;

        return  $prep_stat->get_result()->fetch_assoc();

    }

    function updateBrand($brand_id, $brand_name){

        if ($this->brandExist($brand_name)){
            return 'Brand is already exist.';
        }else{
            $prep_stat = $this->con->prepare("UPDATE brands SET brand_name=? WHERE id=?");
            $prep_stat->bind_param('si', $brand_name,$brand_id);
            if ($prep_stat->execute()){
                return 'Brand updated successfully.';
            }else{
                die($this->con->error);
            }
        }



    }

    public function deleteBrand($brand_id){

            $prep_stat = $this->con->prepare("DELETE FROM brands WHERE id=?");
            $prep_stat->bind_param('i', $brand_id);

            if ($prep_stat->execute()){
                return 'Brand deleted successfully';
            }else{
                die($this->con->error);
            }

    }

}
