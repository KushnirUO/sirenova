<?php
add_filter('posts_search', 'search_by_title_only', 10, 2);

function search_by_title_only($search, $wp_query)
{
    global $wpdb;

    if (empty($search)) {
        return $search; // Якщо пошуковий запит порожній, повертаємо без змін
    }

    if (!is_admin() && $wp_query->is_main_query() && $wp_query->is_search()) {
        $search = $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s ", '%' . $wpdb->esc_like($wp_query->query_vars['s']) . '%');
    }

    return $search;
}