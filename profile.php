<?php
session_start();
$pageTitle = 'Profile';
require_once 'includes/templates/header.php';
require_once 'includes/classes/Users.php';
require_once 'includes/classes/Uploader.php';


if (!isset($_SESSION['user_id'])){
    header("location: $config[app_url]");
    die();
}

$users = new Users();
$user = $users->getUser($_SESSION['user_id']);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if (isset($_POST['username'])){
        $username = $_POST['username'];
        $email = $_POST['email'];

        if (empty($username)){$errors[] = 'Username is required.';}
        if (empty($email)){$errors[] = 'Email is required.';}

        if (empty($errors)){
            $errors = $users->updateUsernameEmail($user['id'], $username, $email, $user['user_email']);
        }

        if (!count($errors)){
            $_SESSION['notify_message'] = 'Account details updated.';
            header("location: $_SERVER[PHP_SELF]");
            die();
        }

    }

    if (isset($_POST['password'])){

        $password       = $_POST['password'];
        $password_conf  = $_POST['password_conf'];

        if (empty($password)){array_push($errors, 'Password is required.');}
        if (empty($password_conf)){array_push($errors, 'Password confirmation is required.');}
        if (strlen($password) < 6){array_push($errors, 'Password must be greater than 6.');}
        if ($password != $password_conf){array_push($errors, "Passwords don't match.");}

        if (empty($errors)){
            $errors = $users->updateUserPassword($user['id'], $password );
        }

        if (!count($errors)){
            $_SESSION['notify_message'] = 'Password updated successfully.';
            header("location: $_SERVER[PHP_SELF]");
            die();
        }

    }

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
            $errors = $users->updateUserImg($user['id'],  $filePath);
        }
        if (!count($errors)){
            $_SESSION['notify_message'] = 'Image updated successfully.';
            header("location: $_SERVER[PHP_SELF]");
            die();
        }
    }



}

?>


<div class="container mt-4 mb-5">
    <?php require_once 'includes/config/errorMessages.php'?>
    <h2 class="text-center my-5">Manage Profile</h2>
    <div class="row">
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card mx-auto">
                <div class="card-header"> Change Username, Email </div>
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" autocomplete="off">
                        <div class="form-group">
                            <label>Username</label>
                            <input name="username" class="form-control" placeholder="Enter Username" type="text" autocomplete="off" value="<?php echo $user['user_name']?>">
                        </div>
                        <div class="form-group">
                            <label>Your email</label>
                            <input name="email" class="form-control" placeholder="Enter Email" type="email" autocomplete="off" value="<?php echo $user['user_email']?>">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block"> Save  </button>
                        </div> <!-- form-group// -->
                    </form>
                </div>
            </div>
        </div>
    <div class="col-lg-4 mb-4 mb-lg-0">
        <div class="card mx-auto">
            <div class="card-header"> Change Password </div>
            <div class="card-body">
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" autocomplete="off">
                    <div class="form-group">
                        <label>Password</label>
                        <input name="password" class="form-control" placeholder="******" type="password" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Re-enter password</label>
                        <input name="password_conf" class="form-control" placeholder="******" type="password" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info btn-block"> Save  </button>
                    </div> <!-- form-group// -->
                </form>
            </div>
        </div>
    </div>
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card mx-auto">
                <div class="card-header"> Change Profile Image </div>
                <img class="card-img-top p-2 mx-auto" style="width: 34%" src="
                <?php
                if (empty($user['avatar'])){
                    echo $config['app_url'] .'layout/images/user.png';
                }else {
                    echo $config['app_url'] .$user['avatar'];
                }
                ?>
                " alt="user">
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" autocomplete="off"  enctype="multipart/form-data">
                        <input type="file" name="avatar" class="form-control" id="avatar">
                        <div class="form-group pt-3">
                            <button type="submit" class="btn btn-info btn-block"> Save  </button>
                        </div> <!-- form-group// -->
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once 'includes/templates/footer.php'?>
