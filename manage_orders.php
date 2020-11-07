<?php
session_start();
$pageTitle = 'Manage invoices';
require_once 'includes/templates/header.php';
require_once 'includes/classes/Database.php';
require_once 'includes/classes/Invoices.php';

$getAllWithPagination = new Database();

$table = 'invoice';
$sql ='SELECT * from invoice';

$pagination = $getAllWithPagination->getAllResultWithPagination('manage_orders',$table, $sql);

?>



    <div class="container my-5">

        <h2 class="text-center my-5">Manage orders</h2>

        <table class="table table-striped table-hover table-bordered text-center">
            <thead>
            <tr>
                <th>#</th>
                <th>Order date</th>
                <th>Customer name</th>
                <th>Net total</th>
                <th>Invoice</th>
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
                        <a class="btn btn-sm btn-warning" href="
                        <?php
                            if (!empty($r['invoice_pdf'])){
                                echo $config['app_url'].$r['invoice_pdf'];
                            }else{
                                echo $config['app_url'].'view_invoice.php?invo_id='.$r['id'];
                            }
                        ?>
                        " download>Download</a>
                        <a class="btn btn-sm btn-info" href="
                        <?php
                        if (!empty($r['invoice_pdf'])){
                            echo $config['app_url'].$r['invoice_pdf'];
                        }else{
                            echo $config['app_url'].'view_invoice.php?invo_id='.$r['id'];
                        }
                        ?>
                        " target="_blank">View</a>
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