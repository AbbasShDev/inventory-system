<?php
session_start();
$pageTitle = 'Manage brands';
require_once 'includes/templates/header.php';
require_once 'includes/classes/Database.php';
require_once 'includes/classes/Brands.php';

$getAllWithPagination = new Database();

$table = 'brands';
$sql ='SELECT * from brands ORDER BY id DESC';

$pagination = $getAllWithPagination->getAllResultWithPagination('manage_brands',$table, $sql);

?>
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
<!-- edit_brand modal -->
<div class="modal edit_brand_modal " id="edit_brand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="edit-brand">
                    <input type="hidden" name="edit_brand_id" id="edit_brand_id" value="">
                    <div class="form-group">
                        <label for="brand_name">Brand Name</label>
                        <input type="text" class="form-control" name="edit_brand_name" id="brand_name" placeholder="Enter brand name">
                        <small id="brand_error" class="form-text text-muted"></small>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info">edit Brand</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- edit_brand modal -->


<div class="container my-5 manage-categories">

    <h2 class="text-center mt-5 mb-3">Manage brands</h2>
    <a href="" class="btn btn-info mb-2" data-toggle="modal" data-target="#add_brand"><i class="fas fa-plus"></i>&nbsp;Add brand</a>
    <table class="table table-striped table-hover table-bordered text-center table-responsive">
        <thead>
        <tr>
            <th style="width: 45px">#</th>
            <th style="width: 595px !important; min-width: 125px !important;">Name</th>
            <th style="width: 192px !important; min-width: 83px !important;">Status</th>
            <th style="width: 307px !important; min-width: 133px !important;">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pagination['sql_result'] as $r):?>
            <tr>
                <td><?php echo $r['id']?></td>
                <td><?php echo $r['brand_name']?></td>
                <td><a class="btn btn-sm btn-success" href="#">Active</a></td>
                <td>
                    <button class="btn btn-sm btn-danger delete-brand" data-bid="<?php echo $r['id']?>">Delete</button>
                    <button class="btn btn-sm btn-info edit_brand" data-toggle="modal" data-target="#edit_brand" data-bid="<?php echo $r['id']?>">Edit</button>
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

        //add brand
        $('.add_brand').on('submit', function (e) {
            e.preventDefault();
            if ($('#brand_name').val() == ''){
                $('#brand_name').addClass('border-danger');
                $('#brand_error').html('<span class="text-danger">Please Enter Brand Name</span>');
            }else {
                $('.add_brand_modal .overlay').show();
                $.ajax({
                    method:'POST',
                    url:'process.php',
                    data:$('.add_brand').serialize(),
                    success: function (data) {
                        $('.add_brand_modal .overlay').hide();
                        if (data == 'Brand created'){
                            $('#brand_name').removeClass('border-danger');
                            $('#brand_error').html('<span class="text-success">Brand added successfully...!</span>');
                            $('#brand_name').val('');
                            window.location.href = '';
                        }else if (data == 'Brand is already exist.'){
                            $('#brand_name').addClass('border-danger');
                            $('#brand_error').html('<span class="text-danger">Brand is already exist.</span>');
                        }else {
                            $('#category_name').addClass('border-danger');
                            $('#cat_error').html('<span class="text-danger">Something went wrong.</span>');
                        }

                    }
                })
            }
        })
        //Update brand (get info)
        $('.edit_brand').on('click', function () {
            $.ajax({
                method:'POST',
                url:'process.php',
                dataType:'json',
                data:{get_brand_id: $(this).data('bid')},
                success: function (data) {
                    $('.edit_brand_modal #edit_brand_id').val(data["id"]);
                    $('.edit_brand_modal #brand_name').val(data["brand_name"]);
                }
            })
        })
        //Update brand
        $('.edit-brand').on('submit', function (e) {
            e.preventDefault();
            if ($('#brand_name').val() == ''){
                $('#brand_name').addClass('border-danger');
                $('#brand_error').html('<span class="text-danger">Please Enter Brand Name</span>');
            }else {
                $.ajax({
                    method:'POST',
                    url:'process.php',
                    data:$('.edit-brand').serialize(),
                    success: function (data) {
                        window.location.href = '';
                    }
                })
            }
        })

        //Delete brand
        $('.delete-brand').on('click', function () {

            if (confirm('Confirm deleting brand..? \nDeleting a brand wil delete all products within it')){

                $.ajax({
                    method:'POST',
                    url:'process.php',
                    data:{delete_brand_id: $(this).data('bid')},
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
