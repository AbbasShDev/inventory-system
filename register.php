<?php
session_start();
$pageTitle = 'Register';
require_once 'includes/templates/header.php';
require_once 'includes/classes/Users.php';

if (isset($_SESSION['user_id'])){
    header('location:dashboard');
    die();
}

$errors = [];
$email = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $username       = $_POST['username'];
    $email          = $_POST['email'];
    $password       = $_POST['password'];
    $password_conf  = $_POST['password_conf'];


    if (empty($username)){array_push($errors, 'Name is required.');}
    if (empty($email)){array_push($errors, 'Email is required.');}
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){array_push($errors, 'You mast enter valid email');}
    if (empty($password)){array_push($errors, 'Password is required.');}
    if (strlen($password) < 6){array_push($errors, 'Password must be greater than 6.');}
    if (empty($password_conf)){array_push($errors, 'Password confirmation is required.');}

    if ($password != $password_conf){array_push($errors, "Passwords don't match.");}

    if (!count($errors)){
        $user = new Users();
        $errors =  $user->createUser(
            $username,
            $email,
            $password
        );

        if (!count($errors)){
            $_SESSION['notify_message'] = 'Account created, please login.';
            header("location: $config[app_url]");
            die();
        }
    }

}

?>

<div class="container mt-5">
    <?php require_once 'includes/config/errorMessages.php'?>
    <div class="card col-md-8 col-lg-4 mx-auto">
        <div class="card-body">
            <a href="<?php echo $config['app_url']?>" class="float-right btn btn-outline-info">Login</a>
            <h4 class="card-title mb-4 mt-1">Register</h4>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" autocomplete="off">
                <div class="form-group">
                    <label>Username</label>
                    <input name="username" class="form-control" placeholder="Enter Username" type="text" autocomplete="off" value="<?php if (!empty($username)) echo $username; ?>">
                </div>
                <div class="form-group">
                    <label>Your email</label>
                    <input name="email" class="form-control" placeholder="Enter Email" type="email" autocomplete="off" value="<?php if (!empty($email)) echo $email; ?>">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input name="password" class="form-control" placeholder="******" type="password" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Re-enter password</label>
                    <input name="password_conf" class="form-control" placeholder="******" type="password" autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info btn-block"> Register  </button>
                </div> <!-- form-group// -->
            </form>
        </div>
    </div> <!-- card.// -->
</div>

<?php require_once 'includes/templates/footer.php'?>
