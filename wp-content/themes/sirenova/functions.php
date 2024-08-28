<?php

// Hide admin bar
show_admin_bar(false);

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
// Знижка на всі товари
require_once get_template_directory() . '/inc/woocommerce/sirenova-discount-products.php';
// AJAX на фільтр магазину
require_once get_template_directory() . '/inc/woocommerce/sirenova-shop-filter-ajax.php';
// Отримати кількість товарів в магазині і категорії
require_once get_template_directory() . '/inc/woocommerce/sirenova-get-products-count.php';
// Дозвіл загружати і відображати SVG
require_once get_template_directory() . '/inc/sirenova-allow-svg.php';
// AJAX сортування магазину
require_once get_template_directory() . '/inc/woocommerce/sirenova-ordering-ajax.php';