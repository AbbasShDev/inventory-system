<?php

class Users {

    private $con;
    public $errors = [];

    public function __construct()
    {
        include_once 'Database.php';
        $db = new Database();
        $this->con = $db->connect();
    }

    private function userExist($email) {
        $prep_stat = $this->con->prepare('SELECT id FROM users WHERE user_email=?');
        $prep_stat->bind_param('s', $email);
        $prep_stat->execute() or die($this->con->error);
        $result = $prep_stat->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function createUser($username, $email, $password){

        if ($this->userExist($email)) {
            array_push($this->errors,'User is already exist.');
            return $this->errors;
        }else{
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $notes = '';
            $prep_stat = $this->con->prepare('INSERT INTO users (user_name, user_email, user_password, user_notes) VALUES (?,?,?,?)');
            $prep_stat->bind_param('ssss',$username, $email, $pass_hash, $notes);
            $result = $prep_stat->execute() or die($this->con->error);

            if (!$result) {
                array_push($this->errors,'Something went wrong while creating account.');
                return $this->errors;
            }
        }

    }

    public function userLogin($email, $password){
        $prep_stat = $this->con->prepare('SELECT * FROM users WHERE user_email=?');
        $prep_stat->bind_param('s', $email);
        $prep_stat->execute() or die($this->con->error);
        $result = $prep_stat->get_result();

        if ($result->num_rows < 1){
            array_push($this->errors,'The Username Or Password You Typed Is Incorrect.');
            return $this->errors;
        }else{
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['user_password'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['user_name'];
                $_SESSION['user_last_login'] = $user['user_last_login'];

                //updating user last login
                $prep_stat = $this->con->prepare('UPDATE users SET user_last_login = now() WHERE user_email=?');
                $prep_stat->bind_param('s', $email);
                $result = $prep_stat->execute() or die($this->con->error);

                if (!$result) {
                    array_push($this->errors,'Something went wrong while creating account.');
                    return $this->errors;
                }

            }else{
                array_push($this->errors,'The Username Or Password You Typed Is Incorrect.');
                return $this->errors;
            }


        }

    }

    public function getUser($user_id){

        $prep_stat = $this->con->prepare("SELECT * FROM users WHERE id=?");
        $prep_stat->bind_param('i', $user_id);
        $prep_stat->execute()or die($this->con->error);

        return  $prep_stat->get_result()->fetch_assoc();
    }

    public function updateUsernameEmail($user_id,$username, $email){
        if ($this->userExist($email)) {
            array_push($this->errors,'Email is already exist.');
            return $this->errors;
        }else{
            $prep_stat = $this->con->prepare('Update users Set user_name=?, user_email=? WHERE id=?');
            $prep_stat->bind_param('ssi',$username, $email, $user_id);
            $result = $prep_stat->execute() or die($this->con->error);

            if (!$result) {
                array_push($this->errors,'Something went wrong while creating account.');
                return $this->errors;
            }
        }
    }

    public function updateUserPassword($user_id, $password){

        $hash_pass = password_hash($password, PASSWORD_DEFAULT);

        $prep_stat = $this->con->prepare('Update users Set user_password=? WHERE id=?');
        $prep_stat->bind_param('si',$hash_pass, $user_id);
        $result = $prep_stat->execute() or die($this->con->error);

        if (!$result) {
            array_push($this->errors,'Something went wrong while creating account.');
            return $this->errors;
        }

    }

    public function updateUserImg($user_id, $filePath){


        $prep_stat = $this->con->prepare('Update users Set avatar=? WHERE id=?');
        $prep_stat->bind_param('si',$filePath, $user_id);
        $result = $prep_stat->execute() or die($this->con->error);

        if (!$result) {
            array_push($this->errors,'Something went wrong while creating account.');
            return $this->errors;
        }

    }




}

