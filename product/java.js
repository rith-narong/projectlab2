$(document).ready(function() {
    // Quantity selector
    $('.js-btn-minus').on('click', function() {
        var $input = $(this).next('.quantity-input');
        var value = parseInt($input.val());
        if (value > 1) {
            value = value - 1;
        }
        $input.val(value);
        $('#hidden-quantity').val(value);
    });
    
    $('.js-btn-plus').on('click', function() {
        var $input = $(this).prev('.quantity-input');
        var value = parseInt($input.val());
        value = value + 1;
        $input.val(value);
        $('#hidden-quantity').val(value);
    });
    
    // Go to top button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $('.js-top').addClass('active');
        } else {
            $('.js-top').removeClass('active');
        }
    });
    
    $('.js-top').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
});