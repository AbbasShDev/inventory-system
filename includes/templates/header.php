<?php
ob_start();
require_once __DIR__.'/../config/app.php'
?>

<!DOCTYPE html>
<html lang="ar" dir="ltr">
<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="author" content="AbbasShDev @AbbasShDev">
    <title><?php echo $config['app_name'].' | '.$pageTitle?></title>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    <!-- app css -->
    <link href="<?php echo $config['app_url']?>layout/css/main.css" rel="stylesheet" />
</head>

<body>
<!-- Start navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-info">
    <a class="navbar-brand" href="<?php echo $config['app_url']?>dashboard.php">Inventory System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo $config['app_url']?>dashboard.php"><i class="fas fa-home">&nbsp;</i>Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo $config['app_url']?>manage_categories.php"><i class="fas fa-tags">&nbsp;</i>Categories</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo $config['app_url']?>manage_brands.php"><i class="fab fa-buffer">&nbsp;</i>Brands</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo $config['app_url']?>manage_products.php"><i class="fas fa-shopping-bag">&nbsp;</i>Products</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo $config['app_url']?>manage_orders.php"><i class="fas fa-file-invoice">&nbsp;</i>Orders</a>
            </li>
            <?php if (isset($_SESSION['user_id'])){?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $config['app_url']?>logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>
<!-- End navbar -->

<!-- Start notification message -->
<?php if (isset($_SESSION['notify_message'])) {?>
    <div class="notify-message">
        <?php echo $_SESSION['notify_message'];?>
    </div>
<?php }
unset($_SESSION['notify_message']); ?>
<!-- End notification message -->
<!-- Start error message -->
<?php if (isset($_SESSION['error_message'])) {?>
    <div class="notify-message bg-danger">
        <?php echo $_SESSION['error_message'];?>
    </div>
<?php }
unset($_SESSION['error_message']); ?>
<!-- End error message -->