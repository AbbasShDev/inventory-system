<?php

class Users
{

    private $con;
    public $errors = [];

    public function __construct()
    {
        include_once 'Database.php';
        $db = new Database();
        $this->con = $db->connect();
    }

    private function userExist($email)
    {
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

    public function createUser($username, $email, $password, $usertype){

        if ($this->userExist($email)) {
            array_push($this->errors,'User is already exist.');
            return $this->errors;
        }else{
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $notes = '';
            $prep_stat = $this->con->prepare('INSERT INTO users (user_name, user_email, user_password, user_type, user_notes) VALUES (?,?,?,?,?)');
            $prep_stat->bind_param('sssss',$username, $email, $pass_hash, $usertype, $notes);
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


}

