<?php

// Hide admin bar
show_admin_bar(true);

// Custom Theme decklaration
add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
}, 20);

// Register menus
register_nav_menus(
    array(
        'header-menu' => __('Меню шапки', 'sirenova'),
        'mobile-sub-menu' => __('Моб. доп. меню'),
        'footer-menu' => __('Меню футеру', 'sirenova'),
    )
);

// Add ACF Option page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

// Allow uploading of SVG files
function allow_svg_uploads($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

// Allow SVG to be displayed in the media library
function fix_svg_display()
{
    echo '<style>
        .attachment-svg { max-width: 100%; height: auto; }
        .wp-post-image { max-width: 100%; height: auto; }
    </style>';
}
add_action('admin_head', 'fix_svg_display');

// Фільтр для форматування цін
add_filter('woocommerce_get_price_html', 'custom_price_format', 100, 2);


function custom_price_format($price, $product)
{
    // Видалення копійок і заміна знака гривні на "грн"
    $price = preg_replace('/,00/', '', $price);
    $price = str_replace(get_woocommerce_currency_symbol(), 'грн', $price);
    return $price;
}

// Create sale-product with ACF-price fields
// Оновлення варіацій при збереженні основного товару
function update_variations_with_custom_prices($product_id)
{
    $product = wc_get_product($product_id);

    if (!$product || !$product->is_type('variable')) {
        return;
    }

    // Отримання кастомних цін
    $custom_price = floatval(get_field('sirenova_price', $product_id));
    $custom_sale_price = floatval(get_field('sirenova_sale_price', $product_id));

    if ($custom_price > 0 || $custom_sale_price > 0) {
        // Оновлення всіх варіацій
        $variations = $product->get_children(); // Отримання ID всіх варіацій

        foreach ($variations as $variation_id) {
            $variation = wc_get_product($variation_id);

            if ($variation && $variation->is_type('variation')) {
                // Задання ціни регулярної
                if ($custom_price > 0) {
                    $variation->set_regular_price($custom_price);
                }

                // Задання ціни зі знижкою
                if ($custom_sale_price > 0) {
                    $variation->set_sale_price($custom_sale_price);
                }

                // Збереження варіації
                $variation->save();
            }
        }
    }
}

// Виклик функції при збереженні товару
add_action('save_post_product', 'update_variations_with_custom_prices');





remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

require get_template_directory() . '/inc/theme-enqueue.php';
require_once get_template_directory() . '/inc/class-sirenova-header-menu.php';
require_once get_template_directory() . '/inc/class-sirenova-footer-menu.php';
require_once get_template_directory() . '/inc/sirenova-color-picker.php';