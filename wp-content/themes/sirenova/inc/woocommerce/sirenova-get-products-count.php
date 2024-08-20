<?php
// Отримати кількість товарів в магазині і категорії
function get_total_products_count()
{
    // Отримуємо глобальний об'єкт запиту WooCommerce
    global $wp_query;

    // Перевіряємо, чи це сторінка магазину або категорії
    if (is_shop() || is_product_category()) {
        // Витягуємо об'єкт запиту WooCommerce
        $query = $wp_query;

        // Повертаємо загальну кількість товарів
        return $query->found_posts;
    }

    return 0; // Якщо не на сторінці магазину або категорії
}