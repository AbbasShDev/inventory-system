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

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select_brand">Brand</label>
                        <select name="select_brand" id="select_brand" class="form-control" required>

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

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select_brand">Brand</label>
                        <select name="select_brand" id="select_brand" class="form-control" required>


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

    <h2 class="text-center mt-5 mb-3">Manage products</h2>
    <a href="#!" class="btn btn-info mb-2"  data-toggle="modal" data-target="#add_product"><i class="fas fa-plus"></i>&nbsp;Add product</a>
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
<script>
    $(document).ready(function () {

        //Get all categories in select
        getAllCategories();
        function getAllCategories(){
            $.ajax({
                method:'POST',
                url:'process.php',
                data:{get_all_categories: 1},
                success: function (data) {
                    $('.edit_product_modal #select_category').html('');
                    $('.edit_product_modal #select_category').html(data);
                    $('.add_product_modal #select_category').html('');
                    $('.add_product_modal #select_category').html(data);
                }
            })
        }

        //Get all brands in select
        getAllBrands();
        function getAllBrands(){
            $.ajax({
                method:'POST',
                url:'process.php',
                data:{get_all_brands: 1},
                success: function (data) {
                    $('.edit_product_modal #select_brand').html('');
                    $('.edit_product_modal #select_brand').html(data);
                    $('.add_product_modal #select_brand').html('');
                    $('.add_product_modal #select_brand').html(data);
                }
            })
        }

        //add product
        $('.add_product').on('submit', function (e) {
            e.preventDefault();
            $('.add_product_modal .overlay').show();
            $.ajax({
                method:'POST',
                url:'process.php',
                data:$('.add_product').serialize(),
                success: function (data) {
                    $('.add_product_modal .overlay').hide();
                    if (data == 'Product created'){
                        $('#product_msg').html('<span class="text-success">Product added successfully...!</span>');
                        $('#product_name').val('');
                        $('#product_price').val('');
                        $('#product_quantity').val('');
                        window.location.href = '';
                    }else{
                        $('#product_msg').html('<span class="text-danger">Something went wrong while adding product, try again</span>');
                        console.log(data);
                    }

                }
            })

        })

        //Update product (get info)
        $('.edit-product').on('click', function () {
            $.ajax({
                method:'POST',
                url:'process.php',
                dataType:'json',
                data:{get_product_info: $(this).data('pid')},
                success: function (data) {
                    $('.edit_product_modal #edit_product_id').val(data["id"]);
                    $('.edit_product_modal #date').val(data["product_added_date"]);
                    $('.edit_product_modal #edit_product_name').val(data["product_name"]);
                    $('.edit_product_modal #select_category').val(data["category_id"]);
                    $('.edit_product_modal #select_brand').val(data["brand_id"]);
                    $('.edit_product_modal #product_price').val(data["product_price"]);
                    $('.edit_product_modal #product_quantity').val(data["product_stock"]);

                }
            })
        })
        //Update product
        $('.edit_product').on('submit', function (e) {
            e.preventDefault();
            if ($('#product_name').val() == ''){
                $('#product_name').addClass('border-danger');
                $('#product_error').html('<span class="text-danger">Please Enter Product Name</span>');
            }else {
                $.ajax({
                    method:'POST',
                    url:'process.php',
                    data:$('.edit_product').serialize(),
                    success: function (data) {
                        window.location.href = '';
                    }
                })
            }
        })

        //Delete product
        $('.delete-product').on('click', function () {

            if (confirm('Confirm deleting product..?')){
                $.ajax({
                    method:'POST',
                    url:'process.php',
                    data:{delete_product_id: $(this).data('pid')},
                    success: function (data) {
                        window.location.href = '';
                    }
                })

            }else {
                return false;
            }

        })

    });
</script>