<?php
add_action('wp_ajax_ordering', 'ordering_ajax');
add_action('wp_ajax_nopriv_ordering', 'ordering_ajax');

function ordering_ajax()
{
    // Перевірка nonce (безпека)
    check_ajax_referer('ordering_nonce', 'security');

    // Отримуємо параметри запиту
    $orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'date'; // Значення за замовчуванням

    // Параметри запиту для WP_Query
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1, // Або будь-яке інше число для обмеження кількості товарів
        'post_status' => 'publish',
        'orderby' => 'date', // Значення за замовчуванням
        'order' => 'DESC', // Значення за замовчуванням
    );

    // Налаштування параметрів сортування
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
        case 'price_up':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_price';
            $args['order'] = 'ASC';
            break;
        case 'price_down':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_price';
            $args['order'] = 'DESC';
            break;
        default:
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
    }

    // Запит для отримання товарів
    $query = new WP_Query($args);

    // Генерація HTML
    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product'); // Виклик шаблону для товару
        }
        $products_html = ob_get_clean();
        $product_count = $query->found_posts;

        // Відправка результатів у форматі JSON
        echo json_encode(array(
            'products' => $products_html,
            'count' => $product_count,
        ));
    } else {
        // Відправка результатів у форматі JSON, коли товарів не знайдено
        echo json_encode(array(
            'products' => '<p>Товари не знайдено</p>',
            'count' => 0,
        ));
    }

    wp_reset_postdata();
    wp_die();
}