<?php
// Отримуємо поточний продукт
global $product;

// Отримуємо всі категорії поточного продукту
$categories = wp_get_post_terms($product->get_id(), 'product_cat');

if (!empty($categories)) {
    // Беремо першу категорію для запиту (або змінюємо це для іншої логіки)
    $category = $categories[0];

    // Виконуємо switch на основі першої категорії
    switch ($category->slug) {
        case 'komplekty-bilyzny':
            // Виклик товарів для категорії 1
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'aksesuary',
                    ),
                ),
            );
            break;

        case 'category-slug-2':
            // Виклик товарів для категорії 2
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'category-slug-2',
                    ),
                ),
            );
            break;

        // Додайте більше категорій при необхідності
        default:
            // Виклик товарів для інших категорій або загальних товарів
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'orderby' => 'rand',
            );
            break;
    }

    // Виконуємо запит для отримання товарів
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div class="related-products">';
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
        echo '</div>';
    }
    wp_reset_postdata();
}