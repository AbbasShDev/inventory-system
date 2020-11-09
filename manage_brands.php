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

    <h2 class="text-center my-5">Manage brands</h2>

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
