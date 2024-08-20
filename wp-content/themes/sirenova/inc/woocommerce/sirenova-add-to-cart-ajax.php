<?php
add_action('wp_ajax_add_to_cart', 'handle_ajax_add_to_cart');
add_action('wp_ajax_nopriv_add_to_cart', 'handle_ajax_add_to_cart');

function handle_ajax_add_to_cart()
{
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['count']);
    $size = sanitize_text_field($_POST['size']);
    $color = sanitize_text_field($_POST['color']);

    if ($product_id > 0 && $quantity > 0) {
        $variation_id = find_variation_id($product_id, $size, $color);

        if ($variation_id) {
            $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, $variation_id);

            if ($cart_item_key) {
                // Оновлюємо лічильник товарів в корзині
                $cart_count = WC()->cart->get_cart_contents_count();

                // Повертаємо відповідь для фронтенду
                wp_send_json_success(array(
                    'message' => 'Товар успішно доданий в корзину!',
                    'cart_count' => $cart_count
                ));
            } else {
                wp_send_json_error(array('message' => 'Не вдалося додати товар в корзину.'));
            }
        } else {
            wp_send_json_error(array('message' => 'Не вдалося знайти відповідну варіацію.'));
        }
    } else {
        wp_send_json_error(array('message' => 'Некоректні дані.'));
    }

    wp_die();
}

function find_variation_id($product_id, $size, $color)
{
    $product = wc_get_product($product_id);
    foreach ($product->get_available_variations() as $variation) {
        $attributes = $variation['attributes'];
        if ($attributes['attribute_pa_size'] == $size && $attributes['attribute_pa_color'] == $color) {
            return $variation['variation_id'];
        }
    }
    return false;
}