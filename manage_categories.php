<?php
session_start();
$pageTitle = 'Manage Categories';
require_once 'includes/templates/header.php';
require_once 'includes/classes/Database.php';
require_once 'includes/classes/Category.php';

$getAllWithPagination = new Database();

$table = 'categories';
$sql ='SELECT p.id, p.category_name, c.category_name as category_parent, p.category_status FROM categories p LEFT JOIN categories c ON p.parent_category = c.id ORDER BY id DESC';

$pagination = $getAllWithPagination->getAllResultWithPagination('manage_categories',$table, $sql);

?>


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
                <button type="submit" class="btn btn-info">Update category</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- edit_category modal -->


<div class="container my-5 manage-categories">

            <h2 class="text-center my-5">Manage Categories</h2>

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
