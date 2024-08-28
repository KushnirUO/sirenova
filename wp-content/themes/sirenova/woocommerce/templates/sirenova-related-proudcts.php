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
            // Виклик товарів для категорії komplekty-bilyzny
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'orderby' => 'rand',
                'post__not_in' => array($product->get_id()), // Виключаємо поточний товар
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'aksesuary',
                    ),
                ),
            );
            break;

        case 'trusyky':
            // Виклик товарів для категорії trusyky
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'orderby' => 'rand',
                'post__not_in' => array($product->get_id()), // Виключаємо поточний товар
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'trusyky',
                    ),
                ),
            );
            break;

        case 'pizhamy':
            // Виклик товарів для категорії pizhamy
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'orderby' => 'rand',
                'post__not_in' => array($product->get_id()), // Виключаємо поточний товар
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'pizhamy',
                    ),
                ),
            );
            break;

        case 'lify':
            // Виклик товарів для категорії lify
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'orderby' => 'rand',
                'post__not_in' => array($product->get_id()), // Виключаємо поточний товар
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'trusyky',
                    ),
                ),
            );
            break;

        case 'kupalnyky':
            // Виклик товарів для категорії kupalnyky
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'orderby' => 'rand',
                'post__not_in' => array($product->get_id()), // Виключаємо поточний товар
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'kupalnyky',
                    ),
                ),
            );
            break;

        case 'inshe':
            // Виклик товарів для категорії inshe
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'orderby' => 'rand',
                'post__not_in' => array($product->get_id()), // Виключаємо поточний товар
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'inshe',
                    ),
                ),
            );
            break;

        // Додайте більше категорій при необхідності
        default:
            // Виклик товарів для інших категорій або загальних товарів
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 12,
                'orderby' => 'rand',
                'post__not_in' => array($product->get_id()), // Виключаємо поточний товар
            );
            break;
    }

    // Виконуємо запит для отримання товарів
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
    }
    wp_reset_postdata();
}