<?php
// Виклик функції при збереженні товару
add_action('save_post_product', 'update_variations_with_custom_prices');
add_action('wp_insert_post', 'update_variations_with_custom_prices');

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
;