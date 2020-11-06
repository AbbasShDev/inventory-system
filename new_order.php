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
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card border-0" style="box-shadow: 0px 0px 6px #bcbdbecc">
                <h5 class="card-header border-0">New order</h5>
                <div class="card-body invoice">
                    <form id="order-form" onsubmit="return false">
                        <div class="form-group row">
                            <label for="order_date" class="col-sm-3 col-form-label" align="right">Order Date</label>
                            <div class="col-sm-6">
                                <input type="text" id="order_date" name="order_date" class="form-control form-control-sm" value="<?php echo date('Y-d-m')?>" readonly>
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
                                <table align="center" width="800px;">
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
<!--                                    <td><b id="number">1</b></td>-->
<!--                                    <td>-->
<!--                                        <select name="pid[]" class="form-control form-control-sm">-->
<!--                                            <option value="">Washing Machine</option>-->
<!--                                        </select>-->
<!--                                    </td>-->
<!--                                    <td><input type="text" name="tqty[]" class="form-control form-control-sm" readonly></td>-->
<!--                                    <td><input type="text" name="qty[]" class="form-control form-control-sm"></td>-->
<!--                                    <td><input type="text" name="peice[]" class="form-control form-control-sm" readonly></td>-->
<!--                                    <td>Rs.1540</td>-->
                                    </tbody>
                                </table>
                                <div class="col-12 d-flex justify-content-center p-1">
                                    <button id="add_order_item" style="width: 150px" class="btn btn-success mx-1">Add</button>
                                    <button id="remove_order_item" style="width: 150px"  class="btn btn-danger mx-1">Remove</button>
                                </div>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sub_total" class="col-sm-3 col-form-label" align="right">Sub total</label>
                            <div class="col-sm-6">
                                <input type="text" id="sub_total" name="sub_total" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gst" class="col-sm-3 col-form-label" align="right">GST(18%)</label>
                            <div class="col-sm-6">
                                <input type="text" id="gst" name="gst" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="discount" class="col-sm-3 col-form-label" align="right">Discount</label>
                            <div class="col-sm-6">
                                <input type="text" id="discount" name="discount" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="net_total" class="col-sm-3 col-form-label" align="right">Net total</label>
                            <div class="col-sm-6">
                                <input type="text" id="net_total" name="net_total" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="paid" class="col-sm-3 col-form-label" align="right">Paid</label>
                            <div class="col-sm-6">
                                <input type="text" id="paid" name="paid" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="due" class="col-sm-3 col-form-label" align="right">Due</label>
                            <div class="col-sm-6">
                                <input type="text" id="due" name="due" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="payment_type" class="col-sm-3 col-form-label" align="right">Payment type</label>
                            <div class="col-sm-6">
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
                            <input type="submit" id="print_invoice" style="width: 150px"  class="btn btn-success mx-1 d-none" value="Print invoice">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/templates/footer.php'?>
