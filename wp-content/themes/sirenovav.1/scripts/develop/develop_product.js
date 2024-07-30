jQuery(document).on('click' ,'.booking_product',function( event  ) {
    event.preventDefault();
    let postId = jQuery(this).attr('data-postId')
        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'render_product_popup',
                postId: postId,
            },
            success: function success(response) {
                jQuery.fancybox.open(response['data']);
            }
        });
});

jQuery(document).on('click' ,'.unbooking_button_product',function( event  ) {
    event.preventDefault();
    let userId = jQuery(this).attr('data-userid'),
        productId= jQuery(this).attr('data-productid')
        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'product_unbooking',
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