<?php
session_start();
$pageTitle = 'Manage Categories';
require_once 'includes/templates/header.php';
require_once 'includes/classes/Database.php';

$getAllWithPagination = new Database();

$table = 'categories';
$sql ='SELECT p.id, p.category_name, c.category_name as category_parent, p.category_status FROM categories p LEFT JOIN categories c ON p.parent_category = c.id';

$pagination = $getAllWithPagination->getAllResultWithPagination('manage_categories',$table, $sql);



?>
<div class="container my-5">

            <h2 class="text-center my-5">Manage Categories</h2>

            <table class="table table-striped table-hover table-bordered text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Status</th>
                    <th>Actions</th>
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
                        <td><a class="btn btn-sm btn-success" href="#">Activate</a></td>
                        <td>
                            <a class="btn btn-sm btn-danger" href="#">Delete</a>
                            <a class="btn btn-sm btn-info" href="#">Edit</a>
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
