$(document).ready(function () {

    //showing notification message
    $('.notify-message').each(function () {

        $(this).animate({
                left:'10px'
            },1000,
            function () {
                $(this).delay(2500).fadeOut();
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

})