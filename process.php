<?php
session_start();
require_once 'includes/classes/Category.php';
require_once 'includes/classes/Brands.php';
require_once 'includes/classes/Products.php';

if (isset($_POST['category_name']) & isset($_POST['parent_category'])){
    $category = new Category();
    $result = $category->addCategory($_POST['parent_category'], $_POST['category_name']);
    echo $result;
}

if (isset($_POST['brand_name'])){
    $brand = new Brands();
    $result = $brand->addBrand($_POST['brand_name']);
    echo $result;
}

if (isset($_POST['product_name']) & isset($_POST['product_price'])){
    $product = new Products();
    $result = $product->addProduct(
        $_POST['select_category'],
        $_POST['select_brand'],
        $_POST['product_name'],
        $_POST['product_price'],
        $_POST['product_quantity'],
        $_POST['date']
        );
    echo $result;
}