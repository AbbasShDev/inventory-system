<?php
session_start();
$pageTitle = 'Manage invoices';
require_once 'includes/templates/header.php';
require_once 'includes/classes/Database.php';
require_once 'includes/classes/Invoices.php';

$getAllWithPagination = new Database();

$table = 'invoice';
$sql ='SELECT * from invoice ORDER BY id DESC';

$pagination = $getAllWithPagination->getAllResultWithPagination('manage_orders',$table, $sql);

?>



    <div class="container my-5">

        <h2 class="text-center my-5">Manage orders</h2>

        <table class="table table-striped table-hover table-bordered text-center table-responsive">
            <thead>
            <tr>
                <th style="width: 45px">#</th>
                <th style="width: 120px !important; min-width: 115px !important;">Order date</th>
                <th style="width: 583px !important; min-width: 268px !important;">Customer name</th>
                <th style="width: 200px !important; min-width: 100px !important;">Net total</th>
                <th style="width: 240px !important; min-width: 225px !important;">Invoice</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pagination['sql_result'] as $r):?>
                <tr>
                    <td><?php echo $r['id']?></td>
                    <td><?php echo $r['order_date']?></td>
                    <td><?php echo $r['customer_name']?></td>
                    <td><?php echo '$'.$r['net_total']?></td>
                    <td>
                        <?php
                        if (!empty($r['invoice_pdf'])){
                            echo '<a class="btn btn-sm btn-warning" target="_blank" href="'.$config['app_url'].$r['invoice_pdf'].'" download>Download</a>';
                        }else{
                            echo '<form action="view_invoice.php" target="_blank" method="post" style="display: inline-block">
                                    <input type="hidden" name="download" value="download">
                                    <input type="hidden" name="invo_id" value="'.$r['id'].'">
                                    <input type="submit" value="Download" class="btn btn-sm btn-warning">
                                </form>';
                        }
                        ?>
                        <?php
                        if (!empty($r['invoice_pdf'])){
                            echo '<a class="btn btn-sm btn-info" target="_blank" href="'.$config['app_url'].$r['invoice_pdf'].'">View</a>';
                        }else{
                            echo '<form action="view_invoice.php" target="_blank" method="post" style="display: inline-block">
                                    <input type="hidden" name="invo_id" value="'.$r['id'].'">
                                    <input type="submit" value="View" class="btn btn-sm btn-info">
                                </form>';
                        }
                        ?>
                        <button class="btn btn-sm btn-danger delete-invoice" data-inid="<?php echo $r['id']?>">Delete</button>
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