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

// Кількість товарів на сторінці магазину і категоірй
function custom_products_per_page($products)
{
    // Встановіть потрібну кількість товарів на сторінці
    return 12; // Замість 12 вставте потрібну кількість товарів
}
add_filter('loop_shop_per_page', 'custom_products_per_page', 20);

// Дефолт сортування на магазину і категоріях
add_filter('woocommerce_default_catalog_orderby', 'custom_default_catalog_orderby');

function custom_default_catalog_orderby($sort_by)
{
    return 'date'; // Сортування по новизні (дата додавання)
}