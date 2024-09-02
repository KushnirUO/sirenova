<?php 
add_action('wp_ajax_wishlist', 'wishlist_ajax');
add_action('wp_ajax_nopriv_wishlist', 'wishlist_ajax');

function wishlist_ajax() {
    // Перевірка, чи переданий параметр product_ids і чи це масив
    if (isset($_POST['product_ids']) && is_array($_POST['product_ids'])) {
        $product_ids = array_map('intval', $_POST['product_ids']); // Перетворюємо значення в int
        $response = [];

        foreach ($product_ids as $product_id) {
            $product = wc_get_product($product_id);

            if ($product) {
                global $post;
                $post = get_post($product_id);
                setup_postdata($post);

                ob_start(); // Починаємо буферизацію виходу
                
                // Встановлюємо глобальну змінну $product для шаблону
                $GLOBALS['product'] = $product;

                // Завантажуємо шаблон content-product.php
                wc_get_template_part('content', 'product');
                
                $html = ob_get_clean(); // Отримуємо розмітку продукту з буфера

                // Додаємо HTML до масиву відповіді
                $response[$product_id] = $html;

                wp_reset_postdata(); // Скидаємо глобальний пост
            }
        }

        // Відправляємо JSON з відповіддю
        wp_send_json_success($response);
    } else {
        wp_send_json_error(['message' => 'Невірний формат даних.']);
    }
}


