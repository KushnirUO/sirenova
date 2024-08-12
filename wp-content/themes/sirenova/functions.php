<?php

// Hide admin bar
show_admin_bar(false);

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
    $custom_sale_price = get_field('sirenova_sale_price', $product_id); // Отримання як є

    if ($custom_price > 0 || !empty($custom_sale_price)) {
        // Оновлення всіх варіацій
        $variations = $product->get_children(); // Отримання ID всіх варіацій

        foreach ($variations as $variation_id) {
            $variation = wc_get_product($variation_id);

            if ($variation && $variation->is_type('variation')) {
                // Задання регулярної ціни
                $variation->set_regular_price($custom_price);

                // Задання ціни зі знижкою, тільки якщо вона не порожня і більше 0
                if (!empty($custom_sale_price) && floatval($custom_sale_price) > 0) {
                    $variation->set_sale_price(floatval($custom_sale_price));
                } else {
                    $variation->set_sale_price(''); // Очистити значення ціни зі знижкою
                }

                // Збереження варіації
                $variation->save();
            }
        }
    }
}

// Обробка аяксу на видалення товару з корзини 
add_action('wp_ajax_remove_cart_item', 'remove_cart_item_ajax');
add_action('wp_ajax_nopriv_remove_cart_item', 'remove_cart_item_ajax');


function remove_cart_item_ajax()
{
    // Перевірка, чи присутній ключ товару в запиті
    if (isset($_POST['cart_item_key'])) {
        $cart_item_key = sanitize_text_field($_POST['cart_item_key']);

        $product = wc_get_product(get_the_ID());
        // Видаляємо товар з корзини
        $removed = WC()->cart->remove_cart_item($cart_item_key);

        if ($removed) {
            // Оновлюємо тотал корзини
            $cart_total = custom_price_format(WC()->cart->get_cart_total(), $product);
            $cart_count = WC()->cart->get_cart_contents_count();

            // Відповідь успіху з додатковими даними
            wp_send_json_success(
                array(
                    'message' => 'Товар успішно видалений',
                    'cart_total' => $cart_total,
                    'cart_count' => $cart_count
                )
            );
        } else {
            // Відповідь помилки
            wp_send_json_error(
                array(
                    'message' => 'Не вдалося видалити товар',
                )
            );
        }
    } else {
        // Відповідь помилки
        wp_send_json_error(
            array(
                'message' => 'Невірний запит',
            )
        );
    }
}

// Обробка аяксу на зміну кількості товару в корзині
add_action('wp_ajax_update_cart_item_quantity', 'update_cart_item_quantity_ajax');
add_action('wp_ajax_nopriv_update_cart_item_quantity', 'update_cart_item_quantity_ajax');

function update_cart_item_quantity_ajax()
{
    // Перевірка, чи присутній ключ товару та нова кількість в запиті
    if (isset($_POST['cart_item_key']) && isset($_POST['quantity'])) {
        $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
        $quantity = intval($_POST['quantity']);

        $product = wc_get_product(get_the_ID());
        // Оновлюємо кількість товару в корзині
        $updated = WC()->cart->set_quantity($cart_item_key, $quantity, true);

        if ($updated) {
            // Оновлюємо тотал корзини та суму товару
            $cart_total = custom_price_format(WC()->cart->get_cart_total(), $product);
            $cart_item = WC()->cart->get_cart_item($cart_item_key);
            $item_total = custom_price_format(wc_price($cart_item['line_total']), $product);

            // Відповідь успіху з додатковими даними
            wp_send_json_success(
                array(
                    'message' => 'Кількість успішно оновлена',
                    'cart_total' => $cart_total,
                    'item_total' => $item_total,
                )
            );
        } else {
            // Відповідь помилки
            wp_send_json_error(
                array(
                    'message' => 'Не вдалося оновити кількість товару',
                )
            );
        }
    } else {
        // Відповідь помилки
        wp_send_json_error(
            array(
                'message' => 'Невірний запит',
            )
        );
    }
}

// Оноволення каунтера товарів в хедері
add_action('wp_ajax_update_cart_counter', 'update_cart_counter_ajax');
add_action('wp_ajax_nopriv_update_cart_counter', 'update_cart_counter_ajax');

function update_cart_counter_ajax()
{
    // Отримуємо загальну кількість товарів у корзині
    $cart_count = WC()->cart->get_cart_contents_count();

    wp_send_json_success(
        array(
            'cart_count' => $cart_count,
        )
    );
}


// Виклик функції при збереженні товару
add_action('save_post_product', 'update_variations_with_custom_prices');
add_action('wp_insert_post', 'update_variations_with_custom_prices');


remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

require get_template_directory() . '/inc/theme-enqueue.php';
require_once get_template_directory() . '/inc/class-sirenova-header-menu.php';
require_once get_template_directory() . '/inc/class-sirenova-footer-menu.php';
require_once get_template_directory() . '/inc/sirenova-color-picker.php';