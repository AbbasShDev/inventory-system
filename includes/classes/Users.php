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

    public function addUserByAdmin($username, $email, $password, $user_role){

        if ($this->userExist($email)) {
            return 'User is already exist.';
        }else{
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $notes = '';
            $prep_stat = $this->con->prepare('INSERT INTO users (user_name, user_email, user_password, user_notes, user_type) VALUES (?,?,?,?,?)');
            $prep_stat->bind_param('sssss',$username, $email, $pass_hash, $notes, $user_role);

            if ($prep_stat->execute()) {
                return 'User created Successfully';
            }else {
                die($this->con->error);
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
                $_SESSION['user_id']            = $user['id'];
                $_SESSION['user_name']          = $user['user_name'];
                $_SESSION['user_last_login']    = $user['user_last_login'];
                $_SESSION['user_role']          = $user['user_type'];


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

    public function updateUsernameEmail($user_id,$username, $email, $login_email){
        if ($email == $login_email){
            $prep_stat = $this->con->prepare('Update users Set user_name=?, user_email=? WHERE id=?');
            $prep_stat->bind_param('ssi',$username, $email, $user_id);
            $result = $prep_stat->execute() or die($this->con->error);

            if (!$result) {
                array_push($this->errors,'Something went wrong while creating account.');
                return $this->errors;
            }
        }else{
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


    }

    public function updateUsernameEmailRole($user_id,$username, $email, $role){

            $prep_stat1 = $this->con->prepare('SELECT user_email FROM users WHERE id=?');
            $prep_stat1->bind_param('i', $user_id);
            $prep_stat1->execute() or die($this->con->error);
            $result = $prep_stat1->get_result()->fetch_assoc();

            $current_email = $result['user_email'];

            if ($email == $current_email){

            }else{
                if ($this->userExist($email)) {
                    return 'Email is already exist.';

                }else{
                    $prep_stat = $this->con->prepare('Update users Set user_name=?, user_email=?, user_type=? WHERE id=?');
                    $prep_stat->bind_param('sssi',$username, $email, $role, $user_id);

                    if ($prep_stat->execute()) {
                        return 'User updated Successfully';
                    }else {
                        die($this->con->error);
                    }
                }
            }



    }

    public function updateAllUserInfo($user_id,$username, $email, $role, $password){

            $hash_pass = password_hash($password, PASSWORD_DEFAULT);

            $prep_stat = $this->con->prepare('Update users Set user_name=?, user_email=?, user_type=?, user_password=? WHERE id=?');
            $prep_stat->bind_param('ssssi',$username, $email, $role, $hash_pass, $user_id);

            if ($prep_stat->execute()) {
                return 'User updated Successfully';
            }else {
                die($this->con->error);
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

    public function deleteUser($user_id){

        $prep_stat1 = $this->con->prepare('SELECT avatar FROM users WHERE id=?');
        $prep_stat1->bind_param('i', $user_id);
        $prep_stat1->execute() or die($this->con->error);
        $result = $prep_stat1->get_result()->fetch_assoc();

        $avatar = $result['avatar'];

        $prep_stat = $this->con->prepare("DELETE FROM users WHERE id=?");
        $prep_stat->bind_param('i', $user_id);

        if ($prep_stat->execute()){
            if (!empty($avatar)){
                unlink($config['root_dir'].$avatar);
            }
            return 'User deleted successfully';
        }else{
            die($this->con->error);
        }

    }




}

