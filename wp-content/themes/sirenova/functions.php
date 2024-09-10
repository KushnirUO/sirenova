<?php

// Hide admin bar
show_admin_bar(true);

// Custom Theme decklaration
add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
}, 20);

// Add ACF Option page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}
;

function set_sale_page_flag()
{
    if (is_page_template('template-sale.php')) {
        global $is_sale_page;
        $is_sale_page = true;
    }
}
add_action('wp', 'set_sale_page_flag');


// Підключення скриптів та стилів
require_once get_template_directory() . '/inc/theme-enqueue.php';
// Реєстрація списків меню
require_once get_template_directory() . '/inc/sirenova-register-menus.php';
// Підключення Header_Menu_Walker
require_once get_template_directory() . '/inc/classes/class-sirenova-header-menu.php';
// Підключення Footer_Menu_Walker
require_once get_template_directory() . '/inc/classes/class-sirenova-footer-menu.php';
// Видалення хуків woocommerce
require_once get_template_directory() . '/inc/woocommerce/sirenova-remove-action.php';
// Вибір кольору для атрибуту колір в адмінці
require_once get_template_directory() . '/inc/woocommerce/sirenova-color-picker.php';
// Пошук
require_once get_template_directory() . '/inc/search/sirenova-search-ajax.php';
// Пошук на сторінці магазину
require_once get_template_directory() . '/inc/search/sirenova-shop-search.php';
// Корзина та міні-корзина
require_once get_template_directory() . '/inc/cart/sirenova-cart-ajax.php';
// Додати товару в корзину
require_once get_template_directory() . '/inc/woocommerce/sirenova-add-to-cart-ajax.php';
// Кастомний формат цін
require_once get_template_directory() . '/inc/woocommerce/sirenova-custom-format-price.php';
// Кастомне поле цін
require_once get_template_directory() . '/inc/woocommerce/sirenova-custom-prices.php';
// Знижка на всі товари - NO READY!!!!!!!!!!
require_once get_template_directory() . '/inc/woocommerce/sirenova-discount-products.php';
// AJAX на фільтр магазину
require_once get_template_directory() . '/inc/woocommerce/sirenova-shop-filter-ajax.php';
// Отримати кількість товарів в магазині і категорії
require_once get_template_directory() . '/inc/woocommerce/sirenova-get-products-count.php';
// Дозвіл загружати і відображати SVG
require_once get_template_directory() . '/inc/sirenova-allow-svg.php';
// AJAX сортування магазину
// require_once get_template_directory() . '/inc/woocommerce/sirenova-ordering-ajax.php';
// AJAX wishlist
require_once get_template_directory() . '/inc/woocommerce/sirenova-wishlist-ajax.php';

// Заборона шорткодам виводити товари не в наявності
add_filter('woocommerce_shortcode_products_query', 'exclude_out_of_stock_from_shortcode');

function exclude_out_of_stock_from_shortcode($args)
{
    // Додаємо meta_query для виключення товарів, яких немає в наявності
    $args['meta_query'][] = array(
        'key' => '_stock_status',
        'value' => 'instock',
        'compare' => '='
    );
    return $args;
}

// Отримати кількість товарів зі знижкою
function get_total_discounted_products_count()
{
    // Отримуємо ID всіх товарів, які зараз на знижці
    $on_sale_products = wc_get_product_ids_on_sale();

    // Фільтруємо тільки батьківські продукти
    $parent_products_count = 0;

    foreach ($on_sale_products as $product_id) {
        $product = wc_get_product($product_id);

        if ($product && $product->is_type('simple') || $product->is_type('variable')) {
            $parent_products_count++;
        }
    }

    return $parent_products_count;
}

// Додати блок оплати у col-2
add_action('woocommerce_checkout_shipping', 'woocommerce_checkout_payment', 20);
// Видалення полів checkout
add_filter('woocommerce_cart_needs_shipping_address', '__return_false');
add_filter('woocommerce_billing_fields', 'custom_remove_billing_fields');

function custom_remove_billing_fields($fields)
{

    unset($fields['billing_company']);
    unset($fields['billing_address_1']);
    unset($fields['billing_address_2']);
    unset($fields['billing_city']);
    unset($fields['billing_postcode']);
    unset($fields['billing_state']);

    return $fields;
}

// Додати заголовок в блок оплати
add_action('woocommerce_review_order_before_payment', 'add_payment_heading');
function add_payment_heading()
{
    echo '<h3>Виберіть спосіб оплати:</h3>';
}

// Видаляємо поле реєстрації облікового запису
add_filter('woocommerce_checkout_fields', 'remove_account_fields');
function remove_account_fields($fields)
{
    unset($fields['account']);
    return $fields;
}

// Видаляем адресу доставки з thankyou-page
add_action('woocommerce_thankyou', 'remove_shipping_address_column', 1);

function remove_shipping_address_column()
{
    ?>
    <style>
        .woocommerce-column.woocommerce-column--2.woocommerce-column--shipping-address.col-2 {
            display: none !important;
        }
    </style>
    <?php
}