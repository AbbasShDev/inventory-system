$(document).ready(function () {

    //showing notification message
    $('.notify-message').each(function () {

        $(this).animate({
                left:'10px'
            },1000,
            function () {
                $(this).delay(6000).fadeOut();
            })


    })


    //add category
    $('.add_category').on('submit', function (e) {
        e.preventDefault();
        if ($('#category_name').val() == ''){
            $('#category_name').addClass('border-danger');
            $('#cat_error').html('<span class="text-danger">Please Enter Category Name</span>');
        }else {
            $('.add_category_modal .overlay').fadeIn();
            $.ajax({
                method:'POST',
                url:'process.php',
                data:$('.add_category').serialize(),
                success: function (data) {
                    $('.add_category_modal .overlay').fadeOut();
                    if (data == 'Category created'){
                        $('#category_name').removeClass('border-danger');
                        $('#cat_error').html('<span class="text-success">Category added successfully...!</span>');
                        $('#category_name').val('');
                    }else {
                        $('#category_name').addClass('border-danger');
                        $('#cat_error').html('<span class="text-danger">Category is already exist.</span>');
                    }

                }
            })
        }
    })

    //add brand
    $('.add_brand').on('submit', function (e) {
        e.preventDefault();
        if ($('#brand_name').val() == ''){
            $('#brand_name').addClass('border-danger');
            $('#brand_error').html('<span class="text-danger">Please Enter Brand Name</span>');
        }else {
            $('.add_brand_modal .overlay').fadeIn();
            $.ajax({
                method:'POST',
                url:'process.php',
                data:$('.add_brand').serialize(),
                success: function (data) {
                    $('.add_brand_modal .overlay').fadeOut();
                    if (data == 'Brand created'){
                        $('#brand_name').removeClass('border-danger');
                        $('#brand_error').html('<span class="text-success">Brand added successfully...!</span>');
                        $('#brand_name').val('');
                    }else{
                        $('#brand_name').addClass('border-danger');
                        $('#brand_error').html('<span class="text-danger">Brand is already exist.</span>');
                    }

                }
            })
        }
    })

    //add product
    $('.add_product').on('submit', function (e) {
        e.preventDefault();
            $('.add_product_modal .overlay').fadeIn();
            $.ajax({
                method:'POST',
                url:'process.php',
                data:$('.add_product').serialize(),
                success: function (data) {
                    $('.add_product_modal .overlay').fadeOut();
                    if (data == 'Product created'){
                        $('#product_msg').html('<span class="text-success">Product added successfully...!</span>');
                        $('#product_name').val('');
                        $('#product_price').val('');
                        $('#product_quantity').val('');
                    }else{
                        $('#product_msg').html('<span class="text-danger">Something went wrong while adding product, try again</span>');
                        console.log(data);
                    }

                }
            })

    })

    //Delete Category
    $('.delete-category').on('click', function () {

        if (confirm('Confirm deleting category..?')){

            $.ajax({
                method:'POST',
                url:'process.php',
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
            url:'process.php',
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
        if ($('#category_name').val() == ''){
            $('#category_name').addClass('border-danger');
            $('#cat_error').html('<span class="text-danger">Please Enter Category Name</span>');
        }else {
            $.ajax({
                method:'POST',
                url:'process.php',
                data:$('.edit_category').serialize(),
                success: function (data) {
                    window.location.href = '';
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

    //Delete brand
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

    //---------------------------- Order -----------------------------
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
        $.ajax({
            method:'POST',
            url:'process.php',
            data:$('.invoice #order-form').serialize(),
            success: function (data) {
                window.location.href = '';
            }
        })
    })



})












