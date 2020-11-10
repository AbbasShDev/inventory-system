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

})












