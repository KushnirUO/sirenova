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
// Корзина та міні-корзина
require_once get_template_directory() . '/inc/cart/sirenova-cart-ajax.php';
// Кастомний формат цін
require_once get_template_directory() . '/inc/woocommerce/sirenova-custom-format-price.php';
// Кастомне поле цін
require_once get_template_directory() . '/inc/woocommerce/sirenova-custom-prices.php';
// Дозвіл загружати і відображати SVG
require_once get_template_directory() . '/inc/sirenova-allow-svg.php';