let home_url = window.location.origin;
// Видалення товару з корзини
jQuery(document).ready(function ($) {
    $('.cart__delete, .min-cart__delete').on('click', function (e) {
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
                    // Видаляємо елемент з DOM
                    $this.closest('.cart__products-product-wrap, .min-cart__products-product-wrap').remove();

                    // Оновлюємо тотал корзини
                    $('.cart__total-price, .min-cart__total-price').html(response.data.cart_total);

                    // Перевіряємо, чи залишились товари в корзині
                    if (response.data.cart_count === 0) {
                        // Заміняємо розмітку корзини, коли всі товари видалені
                        $('.cart__products, .cart-all__wrapper, .min-cart__products, .min-cart__total-wrapper').remove();
                        $('.wrapper.cart').append(`<div class="cart-empty"><p>У Вашій корзині ще немає товарів</p><a href='${home_url}/shop'>Повернутись до магазину</a></div>`);
                        $('.mini-cart-wrapper').append(`<div class="cart-empty"><p>У Вашій корзині ще немає товарів</p><a href='${home_url}/shop'>Повернутись до магазину</a></div>`);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log('Помилка видалення товару:', error);
            }
        });
    });
});

// Оновлення сумми товару та тоталу корзини з каунтеру
jQuery(document).ready(function ($) {
    $('.cart__counter input[name="quantity"]').on('change', function () {
        var quantity = $(this).val();
        var cart_item_key = $(this).closest('.cart__products-product-wrap, .min-cart__products-product-wrap').data('cart_item_key');
        var $this = $(this);

        $.ajax({
            type: 'POST',
            url: wc_cart_params.ajax_url,
            data: {
                action: 'update_cart_item_quantity',
                cart_item_key: cart_item_key,
                quantity: quantity,
            },
            success: function (response) {
                if (response.success) {
                    // Оновлюємо суму товару
                    $this.closest('.cart__products-product-wrap, .min-cart__products-product-wrap').find('.cart__price-all, .min-cart__price-all div').html(response.data.item_total);

                    // Оновлюємо тотал корзини
                    $('.cart__total-price, .min-cart__total-price').html(response.data.cart_total);
                }
            },
            error: function (xhr, status, error) {
                console.log('Помилка оновлення кількості товару:', error);
            }
        });
    });

    // Обробка кнопок "increase" та "decrease"
    $('.cart__counter .increase, .cart__counter .decrease').on('click', function () {
        var $input = $(this).siblings('input[name="quantity"]');
        var currentVal = parseInt($input.val());
        var newVal = $(this).hasClass('increase') ? currentVal + 1 : currentVal - 1;

        if (newVal > 0) {
            $input.val(newVal).trigger('change');
        }
    });
});

// Оноволення каунтера товарів в хедері
jQuery(document).ready(function ($) {
    function updateCartCounter() {
        $.ajax({
            type: 'POST',
            url: wc_cart_params.ajax_url,
            data: {
                action: 'update_cart_counter'
            },
            success: function (response) {
                if (response.success) {
                    var cartCount = response.data.cart_count;

                    // Оновлюємо значення каунтера
                    if (cartCount > 0) {
                        $('.cart__counter-icon').text(cartCount).show();
                    } else {
                        $('.cart__counter-icon').hide();
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log('Помилка оновлення каунтера корзини:', error);
            }
        });
    }

    // Виклик функції при зміні кількості товарів
    $('.cart__counter input[name="quantity"]').on('change', function () {
        var $this = $(this);
        var cart_item_key = $this.closest('.cart__products-product-wrap, .min-cart__products-product-wrap').data('cart_item_key');
        var quantity = $this.val();

        $.ajax({
            type: 'POST',
            url: wc_cart_params.ajax_url,
            data: {
                action: 'update_cart_item_quantity',
                cart_item_key: cart_item_key,
                quantity: quantity,
            },
            success: function (response) {
                if (response.success) {
                    // Оновлюємо суму товару
                    $this.closest('.cart__products-product-wrap, .mon-cart__products-product-wrap').find('.cart__price-all, ..min-cart__price-all div').html(response.data.item_total);

                    // Оновлюємо тотал корзини
                    $('.cart__total-price, .cart__total-price').html(response.data.cart_total);

                    // Оновлюємо каунтер
                    updateCartCounter();
                }
            },
            error: function (xhr, status, error) {
                console.log('Помилка оновлення кількості товару:', error);
            }
        });
    });

    // Виклик функції при видаленні товару з корзини
    $(document).on('click', '.cart__delete, .min-cart__delete', function () {
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
                    $this.closest('.cart__products-product-wrap, .min-cart__products-product-wrap').remove();
                    updateCartCounter();
                }
            },
            error: function (xhr, status, error) {
                console.log('Помилка видалення товару:', error);
            }
        });
    });

    // Виклик функції при додаванні товару в корзину
    $(document).on('added_to_cart', function () {
        updateCartCounter();
    });
});





