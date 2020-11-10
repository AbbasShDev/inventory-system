<?php
session_start();
$pageTitle = 'New order';
require_once 'includes/templates/header.php';
require_once 'includes/classes/Category.php';
require_once 'includes/classes/Brands.php';

if (!isset($_SESSION['user_id'])){
    header('location:index.php');
    die();
}
?>
<!-- pre-loader -->
<div class="overlay" style="position: absolute !important;"><div class="loader"></div></div>
<!-- pre-loader -->
<div class="container mt-4">
    <!-- msg -->
    <div id="msg" >

    </div>
    <!-- msg -->
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card border-0" style="box-shadow: 0px 0px 6px #bcbdbecc">
                <h5 class="card-header border-0">New order</h5>
                <div class="card-body invoice">
                    <form id="order-form" onsubmit="return false">
                        <div class="form-group row">
                            <label for="order_date" class="col-sm-3 col-form-label" align="right">Order Date</label>
                            <div class="col-sm-6">
                                <input type="text" id="order_date" name="order_date" class="form-control form-control-sm" value="<?php echo date('Y-m-d')?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label" align="right">Customer Name</label>
                            <div class="col-sm-6">
                                <input type="text" id="customer_name" name="customer_name" class="form-control form-control-sm" placeholder="Enter customer name" required="required">
                            </div>
                        </div>

                        <div class="card border-0 mb-4" style="box-shadow: 0px 0px 6px #bcbdbecc">
                            <h5 class="card-header border-0">Make order list</h5>
                            <div class="card-body">
                                <table align="center" width="800px;" class="table-responsive">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="text-align: center;">Item name</th>
                                        <th style="text-align: center">Total quantity</th>
                                        <th style="text-align: center">Quantity</th>
                                        <th style="text-align: center">Price</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody id="invoice-item">
<!--                                        Order Items To Be Here-->
                                    </tbody>
                                </table>
                                <div class="col-12 d-flex justify-content-center p-1">
                                    <button id="add_order_item" style="width: 150px" class="btn btn-success mx-1">Add</button>
                                    <button id="remove_order_item" style="width: 150px"  class="btn btn-danger mx-1">Remove</button>
                                </div>

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3 d-flex justify-content-lg-end">
                                <label for="sub_total"  class="col-form-label">Sub total</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" id="sub_total" name="sub_total" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 d-flex justify-content-lg-end">
                                <label for="gst"  class="col-form-label">GST(18%)</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" id="gst" name="gst" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 d-flex justify-content-lg-end">
                                <label for="discount" class="col-form-label" align="right">Discount</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" id="discount" name="discount" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 d-flex justify-content-lg-end">
                                <label for="net_total" class="col-form-label" align="right">Net total</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" id="net_total" name="net_total" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 d-flex justify-content-lg-end">
                                <label for="paid" class="col-form-label" align="right">Paid</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" id="paid" name="paid" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 d-flex justify-content-lg-end">
                                <label for="due" class="col-form-label" align="right">Due</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" id="due" name="due" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 d-flex justify-content-lg-end">
                                <label for="payment_type" class="col-form-label" align="right">Payment type</label>
                            </div>
                            <div class="col-lg-6">
                                <select id="payment_type" name="payment_type" class="form-control form-control-sm" required>
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="Draft">Draft</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center p-1">
                            <input type="submit" id="make-order" style="width: 150px" class="btn btn-info mx-1" value="Order">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/templates/footer.php'?>
<script>
    $(document).ready(function () {

        //add order item
        addOrderItem();
        function addOrderItem(){
            $.ajax({
                method:'POST',
                url:'process.php',
                data:{getNewOrderItem: 1},
                success: function (data) {
                    $('#invoice-item').append(data);
                    let n = 0;
                    $('#invoice-item .number').each(function (){
                        $(this).html(++n);
                    })
                }
            });
        }

        //add order item on click
        $('#add_order_item').on('click', function (e){
            e.preventDefault();
            addOrderItem();
        });

        //remove order item on click
        $('#remove_order_item').on('click', function (e){
            e.preventDefault();
            $('#invoice-item tr').last().remove();
            calculateInvoice(0, 0);
        });

        $('#invoice-item').delegate('.pid', 'change', function (){
            let pid = $(this).val();
            let tr = $(this).parent().parent();
            $('.overlay').show();
            $.ajax({
                method:'POST',
                url:'process.php',
                dataType:'json',
                data:{get_item_price_quantity: pid},
                success: function (data) {
                    $('.overlay').hide();
                    tr.find('.tqty').val(data['product_stock']);
                    tr.find('.qty').val(1);
                    tr.find('.price').val(data['product_price']);
                    tr.find('.total_item_price').html(tr.find('.price').val() * tr.find('.qty').val())
                    tr.find('.pro_name').val(data['product_name']);
                    calculateInvoice(0, 0);
                }
            })
        })

        //order_item_calculation
        $('#invoice-item').delegate('.qty', 'keyup', function (){
            let qty = $(this);
            let tr = $(this).parent().parent();
            if (isNaN(qty.val())){
                alert('Please enter a number');
                qty.val(1);
            }else {
                if ((qty.val() - 0) > (tr.find('.tqty').val() - 0)){
                    alert('Quantity should be less than total quantity');
                    qty.val(1);
                }else {
                    tr.find('.total_item_price').html(qty.val() * tr.find('.price').val());
                    calculateInvoice(0, 0);
                }

            }
        })

        //invoice calculation
        function calculateInvoice(disc, paid_amount){
            let sub_total = 0;
            let gst = 0;
            let net_total = 0;
            let discount = disc;
            let paid = paid_amount;
            let due  = 0;
            $('.total_item_price').each(function (){
                sub_total += Number($(this).html());
            })
            $('.invoice #sub_total').val(sub_total);
            gst = 0.18 * sub_total;
            $('.invoice #gst').val(gst);
            net_total = sub_total + gst;
            net_total += - discount;
            $('.invoice #net_total').val(net_total);
            $('.invoice #discount').val(discount);
            $('.invoice #paid').val(paid_amount);
            due = net_total - paid_amount;
            $('.invoice #due').val(due);

        }
        //invoice calculation
        $('.invoice #discount').keyup(function (){
            let discount = $(this).val();
            let paid = $('.invoice #paid').val();
            calculateInvoice(discount, paid);
        });
        //invoice calculation
        $('.invoice #paid').keyup(function (){
            let paid = $(this).val();
            let discount = $('.invoice #discount').val();
            calculateInvoice(discount, paid);
        });

        $('.invoice #make-order').on('click', function (){

            //let invoice = $('.invoice #order-form').serialize();
            $.ajax({
                method:'POST',
                url:'process.php',
                data:$('.invoice #order-form').serialize(),
                beforeSend:function (){
                    $('.overlay').show();
                },
                success: function (data) {
                    $('#msg').html('');
                    $('#msg').append(data);
                    $(window).scrollTop(0);
                    $('.overlay').hide();

                }
            })
        })

    });
</script>
