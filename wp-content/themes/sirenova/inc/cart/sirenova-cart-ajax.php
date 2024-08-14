<?php
// Обробка аяксу на видалення товару з корзини 
add_action('wp_ajax_remove_cart_item', 'remove_cart_item_ajax');
add_action('wp_ajax_nopriv_remove_cart_item', 'remove_cart_item_ajax');

// Обробка аяксу на зміну кількості товару в корзині
add_action('wp_ajax_update_cart_item_quantity', 'update_cart_item_quantity_ajax');
add_action('wp_ajax_nopriv_update_cart_item_quantity', 'update_cart_item_quantity_ajax');

// Оноволення каунтера товарів в хедері
add_action('wp_ajax_update_cart_counter', 'update_cart_counter_ajax');
add_action('wp_ajax_nopriv_update_cart_counter', 'update_cart_counter_ajax');

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
;

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
;

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
;