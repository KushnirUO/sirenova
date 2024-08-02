<?php

// Hide admin bar
show_admin_bar(false);

// Custom Theme decklaration
add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
}, 20);

// Register menus
register_nav_menus(
    array(
        'header-menu' => __('Меню шапки', 'sirenova'),
        'mobile-sub-menu' => __('Моб. доп. меню'),
        'footer-menu' => __('Меню футеру', 'sirenova'),
    )
);

// Add ACF Option page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

// Allow uploading of SVG files
function allow_svg_uploads($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

// Allow SVG to be displayed in the media library
function fix_svg_display()
{
    echo '<style>
        .attachment-svg { max-width: 100%; height: auto; }
        .wp-post-image { max-width: 100%; height: auto; }
    </style>';
}
add_action('admin_head', 'fix_svg_display');

require get_template_directory() . '/inc/theme-enqueue.php';
require_once get_template_directory() . '/inc/class-sirenova-header-menu.php';
require_once get_template_directory() . '/inc/class-sirenova-footer-menu.php';
