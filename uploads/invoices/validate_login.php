<?php
session_start();
 require_once __DIR__.'/../../includes/config/app.php';
if (!isset($_SESSION['user_id'])) {
    header ("Location: $config[app_url]");
    die();
} else {
    // Get server document root
    $document_root = $_SERVER['DOCUMENT_ROOT'];
    // Get request URL from .htaccess
    $request_url = $_GET['request_url'];

    // Get file name only
    $filename = basename($request_url);

    // Set headers
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename='.$filename);

    // Output file content
    @readfile($document_root.$request_url);
}