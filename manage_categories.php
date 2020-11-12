<?php
session_start();
$pageTitle = 'Manage Categories';
require_once 'includes/templates/header.php';
require_once 'includes/classes/Database.php';
require_once 'includes/classes/Category.php';

if (!isset($_SESSION['user_id'])){
    header("location: $config[app_url]");
    die();
}

if ($_SESSION['user_role'] == 'User'){
    header('location:dashboard');
    die();
}

$getAllWithPagination = new Database();

$table = 'categories';
$sql ='SELECT p.id, p.category_name, c.category_name as category_parent, p.category_status FROM categories p LEFT JOIN categories c ON p.parent_category = c.id ORDER BY id DESC';

$pagination = $getAllWithPagination->getAllResultWithPagination('manage_categories',$table, $sql);
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
<!-- edit_category modal -->
<div class="modal edit_category_modal" id="edit_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- pre-loader -->
            <div class="overlay" style="position: absolute !important;"><div class="loader"></div></div>
            <!-- pre-loader -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="edit_category">
                    <input type="hidden" name="edit_category_id" id="edit_category_id" value="">
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" class="form-control" name="edit_category_name" id="category_name" placeholder="Enter category name">
                        <small id="cat_error" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="parent_category">Select Parent Category</label>
                        <select name="edit_parent_category" id="parent_category" class="form-control">

                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info">Update category</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- edit_category modal -->


<div class="container my-5">

            <h2 class="text-center mt-5 mb-3">Manage Categories</h2>

            <a href="#!" class="btn btn-info mb-2" data-toggle="modal" data-target="#add_category"><i class="fas fa-plus"></i>&nbsp;Add category</a>

            <table class="table table-striped table-hover table-bordered text-center table-responsive">
                <thead>
                <tr>
                    <th style="width: 45px">#</th>
                    <th style="width: 340px !important; min-width: 125px !important;">Name</th>
                    <th style="width: 225px !important; min-width: 98px !important;">Parent</th>
                    <th style="width: 192px !important; min-width: 83px !important;">Status</th>
                    <th style="width: 307px !important; min-width: 133px !important;">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($pagination['sql_result'] as $r):?>
                    <tr>
                        <td><?php echo $r['id']?></td>
                        <td><?php echo $r['category_name']?></td>
                        <td><?php
                            if (empty($r['category_parent'])){
                                echo '<strong>PARENT</strong>';
                            }else{
                                echo $r['category_parent'];
                            }
                            ?>
                        </td>
                        <td><a class="btn btn-sm btn-success" href="#">Active</a></td>
                        <td>
                            <button class="btn btn-sm btn-danger delete-category" data-cid="<?php echo $r['id']?>">Delete</button>
                            <button class="btn btn-sm btn-info edit-category" data-toggle="modal" data-target="#edit_category" data-cid="<?php echo $r['id']?>">Edit</button>
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

        //Get all parent categories in select
        getAllParentCategories();
        function getAllParentCategories(){
            $.ajax({
                method:'POST',
                url:'process',
                data:{get_parents_categories: 1},
                success: function (data) {
                    $('.add_category_modal #parent_category').html('');
                    $('.add_category_modal #parent_category').html(data);
                    $('.edit_category_modal #parent_category').html('');
                    $('.edit_category_modal #parent_category').html(data);
                }
            })
        }

        //add category
        $('.add_category').on('submit', function (e) {
            e.preventDefault();
            if ($('#category_name').val() == ''){
                $('#category_name').addClass('border-danger');
                $('#cat_error').html('<span class="text-danger">Please Enter Category Name</span>');
            }else {
                $('.add_category_modal .overlay').show();
                $.ajax({
                    method:'POST',
                    url:'process',
                    data:$('.add_category').serialize(),
                    success: function (data) {
                        $('.add_category_modal .overlay').hide();
                        if (data == 'Category created'){
                            $('#category_name').removeClass('border-danger');
                            $('#cat_error').html('<span class="text-success">Category added successfully...!</span>');
                            $('#category_name').val('');
                            window.location.href = '';
                        }else if (data == 'Category is already exist.'){
                            $('#category_name').addClass('border-danger');
                            $('#cat_error').html('<span class="text-danger">Category is already exist.</span>');
                        }else {
                            $('#category_name').addClass('border-danger');
                            $('#cat_error').html('<span class="text-danger">Something went wrong.</span>');
                        }

                    }
                })
            }
        })

        //Delete Category
        $('.delete-category').on('click', function () {

            if (confirm('Confirm deleting category..?')){

                $.ajax({
                    method:'POST',
                    url:'process',
                    data:{delete_category_id: $(this).data('cid')},
                    success: function (data) {
                        if (data == 'Sorry this category is a parent of other categories' || data == 'Category deleted successfully'){
                            window.location.href = '';
                        }else {
                            console.log(data);
                        }
                    }
                })


            }else {
                return false;
            }

        })

        //Update category (get info)
        $('.edit-category').on('click', function () {
            $.ajax({
                method:'POST',
                url:'process',
                dataType:'json',
                data:{get_category_id: $(this).data('cid')},
                success: function (data) {
                    $('.edit_category_modal #edit_category_id').val(data["id"]);
                    $('.edit_category_modal #category_name').val(data["category_name"]);
                    $('.edit_category_modal #parent_category').val(data["parent_category"]);
                }
            })
        })
        //Update category
        $('.edit_category').on('submit', function (e) {
            e.preventDefault();
            if ($('.edit_category_modal #category_name').val() == ''){
                $('.edit_category_modal #category_name').addClass('border-danger');
                $('.edit_category_modal #cat_error').html('<span class="text-danger">Please Enter Category Name</span>');
            }else {
                $.ajax({
                    method:'POST',
                    url:'process',
                    data:$('.edit_category').serialize(),
                    success: function (data) {
                        window.location.href = '';
                    }
                })
            }
        })

    });
</script>