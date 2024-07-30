
<?php

add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
}, 20);

register_nav_menus(
    array(
        'Header-menu' => __('Меню шапки', 'sirenovav.1'),
        'Footer-menu' => __('Меню футеру', 'sirenovav.1'),
    )
);

require get_template_directory() . '/inc/theme-enqueue.php';
show_admin_bar(false);
