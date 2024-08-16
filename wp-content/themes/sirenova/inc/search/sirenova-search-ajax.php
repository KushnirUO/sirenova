<?php
// Пошук

// Виклик функції пошуку
add_action('wp_ajax_find_form', 'find_form_ajax');
add_action('wp_ajax_nopriv_find_form', 'find_form_ajax');
function find_form_ajax()
{
    $search_query = sanitize_text_field($_POST['search']);

    function highlight_search_term($text, $term)
    {
        $term = preg_quote($term, '/');
        $replacement = '<span class="search-highlight">$0</span>';
        return preg_replace("/($term)/i", $replacement, $text);
    }

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1, // Отримати всі результати
        'post_status' => 'publish',
        's' => $search_query,
        'fields' => 'ids',
    );

    $query = new WP_Query($args);

    $output = '';

    if ($query->have_posts()) {
        $counter = 0; // Лічильник для всіх знайдених товарів
        $displayed_items = 0; // Лічильник для відображених товарів
        $max_display = 3; // Максимальна кількість товарів для відображення

        foreach ($query->posts as $post_id) {
            $title = get_the_title($post_id);

            // Відображаємо тільки ті товари, де запит знайдено у тайтлі
            if (stripos($title, $search_query) === false) {
                continue;
            }

            $counter++;
            if ($displayed_items >= $max_display) {
                continue; // Пропускаємо додаткові товари після досягнення максимуму
            }

            $displayed_items++;

            $product = wc_get_product($post_id);
            $price = $product->get_price_html();
            $image = get_the_post_thumbnail_url($post_id, 'woocommerce_thumbnail');
            $link = get_permalink($post_id);

            $sizes = [];
            $colors = [];
            $size_output = '';
            $color_output = '';

            if ($product->is_type('variable')) {
                $attributes = $product->get_attributes();

                if (isset($attributes['pa_size'])) {
                    $sizes = $attributes['pa_size']->get_terms();
                }

                if (isset($attributes['pa_color'])) {
                    $colors = $attributes['pa_color']->get_terms();
                }

                foreach ($sizes as $size) {
                    $highlighted_size = highlight_search_term($size->name, $search_query);
                    $size_output .= "<span class='size'>{$highlighted_size}</span>";
                }

                foreach ($colors as $color) {
                    $color_hex = get_term_meta($color->term_id, 'attribute_color', true);
                    $highlighted_color = highlight_search_term($color->name, $search_query);
                    $color_output .= "<div data-color='{$color_hex}'><span style='background: {$color_hex};'></span></div>";
                }
            }

            $highlighted_title = highlight_search_term($title, $search_query);
            $output .= "
            <a class='result-find' href='{$link}'>
                <div class='result-find__img'>
                    <img src='{$image}' alt=''>
                </div>
                <div class='result-find-all'>
                    <p>{$highlighted_title}</p>
                    <div class='product__sizes-like'>
                        <h4>Розмір:</h4>
                        <div class='size'>{$size_output}</div>
                    </div>
                    <div class='product__sizes-like'>
                        <h4>Колір:</h4>
                        <div class='product__colors'>{$color_output}</div>
                    </div>
                    <div class='result-find__price'>
                        <span class=''>Ціна:</span>
                        <p>{$price}</p>
                    </div>
                </div>
            </a>";
        }

        // Якщо результатів більше 3-х, додаємо кнопку для перегляду всіх результатів
        if ($counter > $max_display) {
            $search_page_url = esc_url(add_query_arg('s', $search_query, home_url('/shop/')));
            $output .= "<a href='{$search_page_url}' class='form-show-all'>Переглянути всі({$counter})</a>";
        }

        if ($counter === 0) {
            $output = "<p>Нічого не знайдено.</p>";
        }
    } else {
        $output = "<p>Нічого не знайдено.</p>";
    }

    wp_reset_postdata();

    echo $output;
    wp_die();
}
;