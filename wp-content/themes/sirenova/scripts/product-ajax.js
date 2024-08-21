let home_url = window.location.origin;
var wc_cart_params = typeof wc_cart_params !== 'undefined' ? wc_cart_params : {
    ajax_url: wc_add_to_cart_params ? wc_add_to_cart_params.ajax_url : ''
};
// Видалення товару з корзини
jQuery(document).ready(function ($) {
    // Загальні функції для AJAX запитів
    function sendAjaxRequest(action, data, onSuccess) {
        $.ajax({
            type: 'POST',
            url: wc_cart_params.ajax_url,
            data: $.extend({ action: action }, data),
            success: function (response) {
                if (response.success) {
                    onSuccess(response);
                }
                StopLoader($('.cart__products'));
                StopLoader($('.min-cart__products'));
            },
            error: function (xhr, status, error) {
                console.log(`Помилка ${action}:`, error);
            }
        });
    }

    function updateCartTotal(response) {
        $('.cart__total-price, .min-cart__total-price').html(response.data.cart_total);
    }

    function updateCartCounter() {
        sendAjaxRequest('update_cart_counter', {}, function (response) {
            var cartCount = response.data.cart_count;
            if (cartCount > 0) {
                $('.cart__counter-icon').text(cartCount).show();
            } else {
                $('.cart__counter-icon').hide();
            }
        });
    }

    function handleRemoveItem() {
        var cart_item_key = $(this).data('cart_item_key');
        var $this = $(this);
        StartLoader($(this).closest('.cart__products'));
        StartLoader($(this).closest('.min-cart__products'));

        sendAjaxRequest('remove_cart_item', { cart_item_key: cart_item_key }, function (response) {
            $this.closest('.cart__products-product-wrap, .min-cart__products-product-wrap').addClass('fade-out');
            $this.closest('.cart__products-product-wrap, .min-cart__products-product-wrap').on('animationend', function () {
                $this.closest('.cart__products-product-wrap, .min-cart__products-product-wrap').remove();

                updateCartTotal(response);
                updateInfoTotalPrice();
                if (response.data.cart_count === 0) {
                    $('.cart__products, .cart-all__wrapper, .min-cart__products, .min-cart__total-wrapper').remove();
                    $('.wrapper.cart').append(`<div class="cart-empty"><p>У Вашій корзині ще немає товарів</p><a href='${home_url}/shop'>Повернутись до магазину</a></div>`);
                    $('.mini-cart-wrapper').append(`<div class="cart-empty"><p>У Вашій корзині ще немає товарів</p><a href='${home_url}/shop'>Повернутись до магазину</a></div>`);
                }
                updateCartCounter();
            });




        });
    }

    function handleQuantityChange() {
        var quantity = $(this).val();
        var cart_item_key = $(this).closest('.cart__products-product-wrap, .min-cart__products-product-wrap').data('cart_item_key');
        var $this = $(this);

        StartLoader($(this).closest('.cart__products'));
        StartLoader($(this).closest('.min-cart__products'));

        sendAjaxRequest('update_cart_item_quantity', { cart_item_key: cart_item_key, quantity: quantity }, function (response) {
            $this.closest('.cart__products-product-wrap, .min-cart__products-product-wrap').find('.cart__price-all div, .min-cart__price-all div').html(response.data.item_total);
            updateCartTotal(response);
            updateInfoTotalPrice()
            updateCartCounter();
        });
    }
    function ajaxaddtocart() {
        const form = $('#ajaxform');
        $('.catalog__main-products').addClass('loading');

        let data = {
            action: 'add_to_cart',
            quantity: $('.single__product-main [name="quantity"]').val(),
            product_id: $('.single__product-main [name="product_id"]').val(),
            color: $('.single__product-main [name="color"]:checked').val(),
            size: $('.single__product-main [name="size"]:checked').val(),
        }
        console.log($('.single__product-main [name="color"]'));
        $.ajax({
            type: 'POST',
            url: woocommerce_params.ajax_url,
            data: data,

            success: function (data) {
                console.log(data.data);
                // const response = JSON.parse(data);
                updateCartCounter();
                $('.cart-empty').remove();
                $('.mini-cart-wrapper').replaceWith(data.data.html)



            }

        });
    }

    // Обробка кнопок "increase" та "decrease"
    $('.min-cart__products .cart__counter .increase,.min-cart__products .cart__counter .decrease, .cart__products .cart__counter .increase,.cart__products .cart__counter .decrease').on('click', function () {
        var $input = $(this).siblings('input[name="quantity"]');
        var currentVal = parseInt($input.val());
        var newVal = $(this).hasClass('increase') ? currentVal + 1 : currentVal - 1;
        if (newVal > 0) {
            $input.val(newVal).trigger('change');
        }
    });

    // Події для видалення товару та зміни кількості
    $(document).on('click', '.cart__delete, .min-cart__delete', handleRemoveItem);
    $('.min-cart__products .cart__counter input[name="quantity"]').on('change', handleQuantityChange);
    $('.cart__products .cart__counter input[name="quantity"]').on('change', handleQuantityChange);


    // Додати обробник події при додаванні товару в корзину
    $(document).on('added_to_cart', updateCartCounter);

    $(document).on('click', '.btn.info__btns-cart', ajaxaddtocart);
});

function StartLoader(element) {
    element.addClass('loading');
}

function StopLoader(element) {
    element.removeClass('loading');
}
function updateInfoTotalPrice() {
    let total = parseInt($('.min-cart__total-price').text());
    if (total < 200) {
        $('.min-cart-free p, .cart-free p').text('Мінімальна сума замовлення 200 грн');
        $('.min-cart__total-wrapper > a, .cart__total-wrapper > a').addClass('disabledLink');
    }
    else {
        $('.min-cart-free p, .cart-free p').text('БЕЗКОШТОВНА ДОСТАВКА ВІД 1000 ГРН');
        $('.min-cart__total-wrapper > a, .cart__total-wrapper > a').removeClass('disabledLink');
    }
}

$(document).ready(function () {
    updateInfoTotalPrice();
})


