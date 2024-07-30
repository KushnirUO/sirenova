jQuery(document).on('click' ,'.booking_user',function( event  ) {
    event.preventDefault();
    let userId = jQuery(this).attr('data-userid')
        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'render_user_popup',
                userId: userId,
            },
            success: function success(response) {
                jQuery.fancybox.open(response['data']);
            }
        });
});

jQuery(document).on('click' ,'.unbooking_button_user',function( event  ) {
    event.preventDefault();
    let userId = jQuery(this).attr('data-userid'),
        productId= jQuery(this).attr('data-productid')
        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'user_unbooking',
                userId: userId,
                productId: productId
            },
            success: function success(response) {
                if( jQuery('.item').length === 1 ) {
                    jQuery.fancybox.close();
                }
                var btn = 'button[' + response['data'] + ']';
                jQuery(btn).closest('.item').remove();
            }
        });
});