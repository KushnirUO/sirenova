// Видалення товару з корзини
jQuery(document).ready(function ($) {
    $('.cart__delete').on('click', function (e) {
        e.preventDefault();

        var cart_item_key = $(this).data('cart_item_key');
        var $this = $(this);

        $.ajax({
            type: 'POST',
            url: wc_cart_params.ajax_url,
            data: {
                action: 'remove_cart_item',
                cart_item_key: cart_item_key,
            },
            success: function (response) {
                if (response.success) {
                    // Оновлюємо UI, наприклад, видаляємо елемент з DOM
                    $this.closest('.cart__products-product-wrap').remove();
                    // Якщо потрібно оновити інші частини корзини, додайте тут додатковий код
                }
            },
            error: function (xhr, status, error) {
                console.log('Помилка видалення товару:', error);
            }
        });
    });
});


