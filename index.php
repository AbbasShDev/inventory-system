<?php
session_start();
$pageTitle = 'Login';
require_once 'includes/templates/header.php';
require_once 'includes/classes/Users.php';

if (isset($_SESSION['user_id'])){
    header('location:dashboard.php');
    die();
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email          = $_POST['email'];
    $password       = $_POST['password'];



    if (empty($email)){array_push($errors, 'Email is required.');}
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){array_push($errors, 'You mast enter valid email');}
    if (empty($password)){array_push($errors, 'Password is required.');}
    if (strlen($password) < 6){array_push($errors, 'Password must be greater than 6.');}

    if (!count($errors)){
        $user = new Users();
        $errors =  $user->userLogin($email, $password);

        if (!count($errors)){
            $_SESSION['notify_message'] = 'Welcome back '.$_SESSION['user_name'];
            header('location:dashboard.php');
            die();
        }
    }

}

?>

<div class="container mt-5">
    <?php require_once 'includes/config/errorMessages.php'?>
    <div class="card col-md-8 col-lg-4 mx-auto">
        <div class="card-body">
            <a href="register.php" class="float-right btn btn-outline-info">Register</a>
            <h4 class="card-title mb-4 mt-1">Login</h4>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" autocomplete="off">
                <div class="form-group">
                    <label>Your email</label>
                    <input name="email" class="form-control" placeholder="Email" type="email">
                </div> <!-- form-group// -->
                <div class="form-group">
                    <a class="float-right text-info" href="#">Forgot?</a>
                    <label>Your password</label>
                    <input name="password" class="form-control" placeholder="******" type="password">
                </div> <!-- form-group// -->
                <div class="form-group">
                    <button type="submit" class="btn btn-info btn-block"> Login  </button>
                </div> <!-- form-group// -->
            </form>
        </div>
    </div> <!-- card.// -->
</div>

<?php require_once 'includes/templates/footer.php'?>
