<?php
add_action('wp_ajax_ajaxfilter', 'shop_filter_ajax');
add_action('wp_ajax_nopriv_ajaxfilter', 'shop_filter_ajax');

function shop_filter_ajax()
{
    // Отримуємо параметри з запиту
    $product_cats = isset($_POST['product_cats']) ? array_map('intval', $_POST['product_cats']) : array();
    $min_price = isset($_POST['min_price']) ? floatval($_POST['min_price']) : 0;
    $max_price = isset($_POST['max_price']) ? floatval($_POST['max_price']) : 0;
    $color = isset($_POST['color']) ? sanitize_text_field($_POST['color']) : '';
    $size = isset($_POST['size']) ? sanitize_text_field($_POST['size']) : '';
    $orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : '';
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $sale = isset($_POST['sale-page']);

    // Кількість товарів на сторінці
    $products_per_page = 12;

    // Отримуємо всі ID товарів на знижці
    $sale_product_ids = wc_get_product_ids_on_sale();
    // Якщо ми на сторінці розпродажу
    if ($sale == 'sale') {
        // Перевірка наявності ID товарів на знижці
        if (empty($sale_product_ids)) {
            echo json_encode(array(
                'products' => '<p>Товари не знайдено</p>',
                'count' => 0,
            ));
            wp_die();
        }


        // Основний масив аргументів для WP_Query
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $products_per_page,
            'post_status' => 'publish',
            'paged' => $paged,
            'post__in' => $sale_product_ids, // Використовуємо тільки товари на знижці
            'orderby' => 'post__in', // Сортування по ID
            'tax_query' => array('relation' => 'AND'),
            'meta_query' => array('relation' => 'AND'),
        );
    } else {
        // Основний масив аргументів для WP_Query без обмеження ID
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $products_per_page,
            'post_status' => 'publish',
            'paged' => $paged,
            'tax_query' => array('relation' => 'AND'),
            'meta_query' => array('relation' => 'AND'),
        );
    }

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
            'terms' => explode(',', $color),
        );
    }

    // Фільтр за розміром
    if (!empty($size)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'pa_size',
            'field' => 'slug',
            'terms' => explode(',', $size),
        );
    }

    // Фільтр за мінімальною ціною
    if ($min_price > 0) {
        $args['meta_query'][] = array(
            'relation' => 'OR',
            array(
                'key' => 'sirenova_sale_price',
                'value' => $min_price,
                'compare' => '>=',
                'type' => 'NUMERIC'
            ),
            array(
                'key' => 'sirenova_price',
                'value' => $min_price,
                'compare' => '>=',
                'type' => 'NUMERIC'
            ),
        );
    }

    // Фільтр за максимальною ціною
    if ($max_price > 0) {
        $args['meta_query'][] = array(
            'relation' => 'OR',
            array(
                'key' => 'sirenova_sale_price',
                'value' => $max_price,
                'compare' => '<=',
                'type' => 'NUMERIC'
            ),
            array(
                'key' => 'sirenova_price',
                'value' => $max_price,
                'compare' => '<=',
                'type' => 'NUMERIC'
            ),
        );
    }

    // Додавання сортування
    if ($orderby === 'price_up' || $orderby === 'price_down') {
        $order = ($orderby === 'price_up') ? 'ASC' : 'DESC';
        $args['meta_key'] = 'sirenova_price';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = $order;
    } else {
        switch ($orderby) {
            case 'popular':
                $args['meta_key'] = 'total_sales';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            case 'new':
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
                break;
            default:
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
                break;
        }
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