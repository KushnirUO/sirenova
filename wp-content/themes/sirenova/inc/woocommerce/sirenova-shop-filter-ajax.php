<?php
add_action("wp_ajax_ajaxfilter", "shop_filter_ajax");
add_action("wp_ajax_nopriv_ajaxfilter", "shop_filter_ajax");
function shop_filter_ajax()
{
    // Отримуємо параметри з запиту
    $product_cats = isset($_POST['product_cats']) ? array_map('intval', $_POST['product_cats']) : array();
    $min_price = isset($_POST['min_price']) ? floatval($_POST['min_price']) : 0;
    $max_price = isset($_POST['max_price']) ? floatval($_POST['max_price']) : 0;
    $color = isset($_POST['color']) ? sanitize_text_field($_POST['color']) : '';
    $size = isset($_POST['size']) ? sanitize_text_field($_POST['size']) : '';

    // Базовий масив аргументів для WP_Query
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1, // Отримати всі відповідні товари
        'post_status' => 'publish',
        'tax_query' => array('relation' => 'AND'), // Використовуємо для категорій та атрибутів
        'meta_query' => array('relation' => 'AND'), // Використовуємо для цін
    );

    // Фільтр за категоріями
    if (!empty($product_cats)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $product_cats,
        );
    }

    // Фільтр за кольором
    if (!empty($color)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'pa_color',
            'field' => 'slug',
            'terms' => explode(',', $color), // Розділяємо кілька значень
        );
    }

    // Фільтр за розміром
    if (!empty($size)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'pa_size',
            'field' => 'slug',
            'terms' => explode(',', $size), // Розділяємо кілька значень
        );
    }

    // Фільтр за мінімальною ціною
    if ($min_price > 0) {
        $args['meta_query'][] = array(
            'key' => '_price',
            'value' => $min_price,
            'compare' => '>=',
            'type' => 'NUMERIC'
        );
    }

    // Фільтр за максимальною ціною
    if ($max_price > 0) {
        $args['meta_query'][] = array(
            'key' => '_price',
            'value' => $max_price,
            'compare' => '<=',
            'type' => 'NUMERIC'
        );
    }

    // Виконуємо запит
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
        $products_html = ob_get_clean();
        $product_count = $query->found_posts;

        echo json_encode(array(
            'products' => $products_html,
            'count' => $product_count,
        ));
    } else {
        echo json_encode(array(
            'products' => '<p>Товари не знайдено</p>',
            'count' => 0,
        ));
    }

    wp_reset_postdata();
    wp_die();
}