<?php

function apply_discount_to_all_products($discount_percentage)
{
    global $wpdb; // Ініціалізуємо глобальну змінну для SQL-запитів

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
    );
    $products = get_posts($args);

    foreach ($products as $product_post) {
        $product = wc_get_product($product_post->ID);

        if ($product->is_type('variable')) {
            // Обробка варіативного товару
            $variations = $product->get_children();

            foreach ($variations as $variation_id) {
                $regular_price = (float) get_post_meta($variation_id, '_regular_price', true);

                if ($regular_price) {
                    $discounted_price = $regular_price * (1 - ($discount_percentage / 100));

                    // Прямий SQL-запит для оновлення мета-полів
                    $wpdb->update(
                        $wpdb->postmeta,
                        array('meta_value' => $discounted_price),
                        array('post_id' => $variation_id, 'meta_key' => '_sale_price')
                    );
                    $wpdb->update(
                        $wpdb->postmeta,
                        array('meta_value' => $discounted_price),
                        array('post_id' => $variation_id, 'meta_key' => '_regular_price')
                    );

                    // Додаємо мета-поле для відмітки про застосування знижки
                    update_post_meta($variation_id, '_custom_discount_applied', true);
                }
            }
        } else {
            // Обробка простого товару
            $regular_price = (float) get_post_meta($product->get_id(), '_regular_price', true);

            if ($regular_price) {
                $discounted_price = $regular_price * (1 - ($discount_percentage / 100));

                // Прямий SQL-запит для оновлення мета-полів
                $wpdb->update(
                    $wpdb->postmeta,
                    array('meta_value' => $discounted_price),
                    array('post_id' => $product->get_id(), 'meta_key' => '_sale_price')
                );
                $wpdb->update(
                    $wpdb->postmeta,
                    array('meta_value' => $discounted_price),
                    array('post_id' => $product->get_id(), 'meta_key' => '_regular_price')
                );

                // Додаємо мета-поле для відмітки про застосування знижки
                update_post_meta($product->get_id(), '_custom_discount_applied', true);
            }
        }
    }

    // Зберігаємо знижку в опціях
    update_option('current_discount_percentage', $discount_percentage);
}

function remove_discount_from_all_products()
{
    global $wpdb; // Ініціалізуємо глобальну змінну для SQL-запитів

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_custom_discount_applied',
                'value' => true,
            ),
        ),
    );
    $products = get_posts($args);

    foreach ($products as $product_post) {
        $product = wc_get_product($product_post->ID);

        if ($product->is_type('variable')) {
            // Обробка варіативного товару
            $variations = $product->get_children();

            foreach ($variations as $variation_id) {
                // Видалення мета-поля sale_price
                $wpdb->delete(
                    $wpdb->postmeta,
                    array(
                        'post_id' => $variation_id,
                        'meta_key' => '_sale_price'
                    )
                );
                $wpdb->delete(
                    $wpdb->postmeta,
                    array(
                        'post_id' => $variation_id,
                        'meta_key' => '_regular_price'
                    )
                );
                delete_post_meta($variation_id, '_custom_discount_applied');
            }
        } else {
            // Обробка простого товару
            $wpdb->delete(
                $wpdb->postmeta,
                array(
                    'post_id' => $product->get_id(),
                    'meta_key' => '_sale_price'
                )
            );
            $wpdb->delete(
                $wpdb->postmeta,
                array(
                    'post_id' => $product->get_id(),
                    'meta_key' => '_regular_price'
                )
            );
            delete_post_meta($product->get_id(), '_custom_discount_applied');
        }
    }

    // Видаляємо знижку з опцій
    delete_option('current_discount_percentage');
}

// Хук для обробки форми ACF
function manage_discounts_acf($post_id)
{
    // Перевіряємо, чи це збереження сторінки опцій ACF
    if ($post_id !== 'options') {
        return;
    }

    $discount_percentage = get_field('discount_percentage', 'option');

    if (is_numeric($discount_percentage)) {
        if ($discount_percentage > 0) {
            apply_discount_to_all_products($discount_percentage);
        } else {
            remove_discount_from_all_products();
        }
    } else {
        remove_discount_from_all_products();
    }
}
add_action('acf/save_post', 'manage_discounts_acf', 20);