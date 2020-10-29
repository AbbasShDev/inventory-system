<?php
session_start();
$pageTitle = 'Login';
require_once 'includes/templates/header.php';


?>

<div class="container mt-5">
    <div class="card col-md-8 col-lg-4 mx-auto">
        <div class="card-body">
            <a href="register.php" class="float-right btn btn-outline-info">Register</a>
            <h4 class="card-title mb-4 mt-1">Login</h4>
            <form>
                <div class="form-group">
                    <label>Your email</label>
                    <input name="" class="form-control" placeholder="Email" type="email">
                </div> <!-- form-group// -->
                <div class="form-group">
                    <a class="float-right text-info" href="#">Forgot?</a>
                    <label>Your password</label>
                    <input class="form-control" placeholder="******" type="password">
                </div> <!-- form-group// -->
                <div class="form-group">
                    <button type="submit" class="btn btn-info btn-block"> Login  </button>
                </div> <!-- form-group// -->
            </form>
        </div>
    </div> <!-- card.// -->
</div>

<?php require_once 'includes/templates/footer.php'?>
