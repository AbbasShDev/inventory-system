<?php
session_start();
require_once 'includes/config/app.php';

if (!isset($_SESSION['user_id'])){
    header("location: $config[app_url]");
    die();
}

if (isset($_SESSION['user_name'])){
    $_SESSION = [];
    $_SESSION['error_message'] = 'You are logged out, see you soon.';
    header("location: $config[app_url]");
    die();
}

