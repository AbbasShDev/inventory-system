<?php
session_start();
if (isset($_SESSION['user_name'])){
    $_SESSION = [];
    $_SESSION['error_message'] = 'You are logged out, see you soon.';
    header('location:index.php');
    die();
}

