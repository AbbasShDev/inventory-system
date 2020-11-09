<?php
session_start();
$pageTitle = 'Manage products';
require_once 'includes/templates/header.php';
require_once 'includes/classes/Database.php';
require_once 'includes/classes/Brands.php';
require_once 'includes/classes/Category.php';

$getAllWithPagination = new Database();

$table = 'products';
$sql ='SELECT products.*, categories.category_name, brands.brand_name FROM products, categories, brands WHERE products.category_id=categories.id AND products.brand_id=brands.id ORDER BY id DESC';

$pagination = $getAllWithPagination->getAllResultWithPagination('manage_products',$table, $sql);

?>
<!-- edit_product modal -->
<div class="modal edit_product_modal" id="edit_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- pre-loader -->
            <div class="overlay" style="position: absolute !important;"><div class="loader"></div></div>
            <!-- pre-loader -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="edit_product">
                    <input type="hidden" name="edit_product_id" id="edit_product_id" value="">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d')?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="edit_product_name" name="edit_product_name" placeholder="Enter Product Name" required>
                            <small id="product_error" class="form-text text-muted"></small>
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
                <button type="submit" class="btn btn-info">Update product</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- edit_product modal -->

<div class="container my-5 manage-categories">

    <h2 class="text-center my-5">Manage products</h2>

    <table class="table table-striped table-hover table-bordered text-center table-responsive">
        <thead>
        <tr>
            <th>#</th>
            <th style="width: 370px !important; min-width: 370px !important;">Product</th>
            <th style="width: 110px !important; min-width: 110px !important;">Category</th>
            <th>Brand</th>
            <th>Price</th>
            <th>Stock</th>
            <th style="min-width: 116px !important;">Added Date</th>
            <th>Status</th>
            <th style="min-width: 134px !important;">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pagination['sql_result'] as $r):?>
            <tr>
                <td><?php echo $r['id']?></td>
                <td><?php echo $r['product_name']?></td>
                <td><?php echo $r['category_name']?></td>
                <td><?php echo $r['brand_name']?></td>
                <td><?php echo $r['product_price']?></td>
                <td><?php echo $r['product_stock']?></td>
                <td><?php echo $r['product_added_date']?></td>
                <td><a class="btn btn-sm btn-success" href="#">Active</a></td>
                <td>
                    <button class="btn btn-sm btn-danger delete-product" data-pid="<?php echo $r['id']?>">Delete</button>
                    <button class="btn btn-sm btn-info edit-product" data-toggle="modal" data-target="#edit_product" data-pid="<?php echo $r['id']?>">Edit</button>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>


    <div class="float-left">
        Page <?php echo $pagination['page']?> of <?php echo $pagination['total_pages']?>
    </div>
    <div class="float-right">
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-sm">
                <?php echo $pagination['pagination']?>
            </ul>
        </nav>
    </div>

</div>

<?php require_once 'includes/templates/footer.php'?>
