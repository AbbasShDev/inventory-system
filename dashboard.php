<?php
session_start();
$pageTitle = 'Dashboard';
require_once 'includes/templates/header.php';
require_once 'includes/classes/Category.php';
require_once 'includes/classes/Brands.php';

if (!isset($_SESSION['user_id'])){
    header('location:index.php');
    die();
}

?>
<!-- add_category modal -->
<div class="modal add_category_modal" id="add_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- pre-loader -->
            <div class="overlay" style="position: absolute !important;"><div class="loader"></div></div>
            <!-- pre-loader -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="add_category">
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter category name">
                        <small id="cat_error" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="parent_category">Select Parent Category</label>
                        <select name="parent_category" id="parent_category" class="form-control">
                            <option value="0" selected>Parent</option>
                            <?php
                            $category = new Category();
                            $categories = $category->getAllCategories(0);
                            foreach ($categories as $cat):?>
                                <option value="<?php echo $cat['id']?>" >
                                    <?php echo $cat['category_name']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info">Add category</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- add_category modal -->

<!-- add_brand modal -->
<div class="modal add_brand_modal" id="add_brand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- pre-loader -->
            <div class="overlay" style="position: absolute !important;"><div class="loader"></div></div>
            <!-- pre-loader -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="add_brand">
                    <div class="form-group">
                        <label for="brand_name">Brand Name</label>
                        <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Enter brand name">
                        <small id="brand_error" class="form-text text-muted"></small>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info">Add Brand</button>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>
<!-- add_brand modal -->

<!-- add_product modal -->
<div class="modal add_product_modal" id="add_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- pre-loader -->
            <div class="overlay" style="position: absolute !important;"><div class="loader"></div></div>
            <!-- pre-loader -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="add_product">
                    <small id="product_msg" class="form-text text-muted"></small>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d')?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="select_category">Category</label>
                        <select name="select_category" id="select_category" class="form-control" required>
                            <option value="0" selected disabled>Select Category</option>
                            <?php
                            $category = new Category();
                            $categories = $category->getAllCategories();
                            foreach ($categories as $cat):?>
                                <option value="<?php echo $cat['id']?>" >
                                    <?php echo $cat['category_name']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select_brand">Brand</label>
                        <select name="select_brand" id="select_brand" class="form-control" required>
                            <option value="0" selected disabled>Select Brand</option>
                                <?php
                                $brand = new Brands();
                                $brands = $brand->getAllbrands();
                                foreach ($brands as $br):?>
                                    <option value="<?php echo $br['id']?>" >
                                        <?php echo $br['brand_name']?>
                                    </option>
                                <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="product_price">Product Price</label>
                        <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Enter Product Price">
                    </div>
                    <div class="form-group">
                        <label for="product_quantity">Quantity</label>
                        <input type="text" class="form-control" id="product_quantity" name="product_quantity" placeholder="Enter Product Quantity">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info">Add product</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- add_product modal -->

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card mx-auto h-100">
                <img class="card-img-top p-2 mx-auto" style="width: 60%" src="<?php echo $config['app_url']?>layout/images/user.png" alt="user">
                <div class="card-body">
                    <h4 class="card-title">Profile Info</h4>
                    <p class="card-text"><i class="fas fa-user text-info"></i>&nbsp;Abbas Alshaqaq</p>
                    <p class="card-text"><i class="fas fa-user-tag text-info"></i>&nbsp;Admin</p>
                    <p class="card-text"><i class="fas fa-clock text-info"></i>&nbsp;Last Login: xxxx-xx-xx</p>
                    <a href="#!" class="btn btn-info"><i class="far fa-edit"></i>&nbsp;Edit Profile</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="jumbotron w-100 h-100 pt-2">
                <h1 class="pb-5">Welcome Admin,</h1>
                <div class="row">
                    <div class="col-sm-6 d-flex justify-content-center">
                        <iframe src="http://free.timeanddate.com/clock/i7itywhw/n5397/szw160/szh160/hoc000/hbw4/cf100/hgr0/fav0/fiv0/mqc000/mqs3/mql25/mqw6/mqd96/mhc000/mhs3/mhl20/mhw6/mhd96/mmc000/mms3/mml10/mmw2/mmd96/hhw16/hmw16/hmr4/hsc000/hss3/hsl90" frameborder="0" width="160" height="160"></iframe>
                    </div>
                    <div class="col-sm-6 mt-5 mt-sm-0">
                        <div class="card border-0">
                            <div class="card-body">
                                <h4 class="card-title">Orders</h4>
                                <p class="card-text">Here you can make a new orders and print invoices.</p>
                                <a href="#!" class="btn btn-secondary"><i class="fas fa-plus"></i>&nbsp;New Order</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container my-4">
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Categories<i class="fas fa-tags float-right text-info"></i></h4>
                    <p class="card-text" style="height: 72px">Here you can manage your categories and add new category or sub-category</p>
                    <a href="#!" class="btn btn-success" data-toggle="modal" data-target="#add_category"><i class="fas fa-plus"></i>&nbsp;Add</a>
                    <a href="manage_categories.php" class="btn btn-warning"><i class="fas fa-pencil-alt"></i>&nbsp;Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Brands<i class="fab fa-buffer float-right text-info"></i></h4>
                    <p class="card-text" style="height: 72px">Here you can manage your brands and add new brand</p>
                    <a href="#!" class="btn btn-success" data-toggle="modal" data-target="#add_brand"><i class="fas fa-plus"></i>&nbsp;Add</a>
                    <a href="manage_brands.php" class="btn btn-warning"><i class="fas fa-pencil-alt"></i>&nbsp;Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Products<i class="fas fa-shopping-bag float-right text-info"></i></h4>
                    <p class="card-text" style="height: 72px">Here you can manage your products and add new product</p>
                    <a href="#!" class="btn btn-success"  data-toggle="modal" data-target="#add_product"><i class="fas fa-plus"></i>&nbsp;Add</a>
                    <a href="#!" class="btn btn-warning"><i class="fas fa-pencil-alt"></i>&nbsp;Manage</a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once 'includes/templates/footer.php'?>
