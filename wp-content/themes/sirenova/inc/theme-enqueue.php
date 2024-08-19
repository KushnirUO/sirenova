<?php
add_action('wp_enqueue_scripts', 'sirenova_scripts');

function sirenova_scripts()
{
    wp_deregister_style('woocommerce-general');
    wp_deregister_style('woocommerce-layout');


    wp_enqueue_style('normalize', get_template_directory_uri() . '/style/normalize.css');
    wp_enqueue_style('dev_0_basic', get_template_directory_uri() . '/style/dev_0_basic.css');
    wp_enqueue_style('dev_1', get_template_directory_uri() . '/style/dev_1.css');
    wp_enqueue_style('slick', get_template_directory_uri() . '/style/slick.css');
    wp_enqueue_style('customcss', get_template_directory_uri() . '/style/custom.css');
    wp_enqueue_style('responsive', get_template_directory_uri() . '/style/responsive.css');

    wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css');

    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/scripts/jquery-3.7.1.min.js');
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-new', get_template_directory_uri() . '/scripts/jquery-3.7.1.min.js');

    wp_enqueue_script('jquery-ui', 'https://code.jquery.com/ui/1.14.0/jquery-ui.js');

    wp_enqueue_script('slick', get_template_directory_uri() . '/scripts/slick.min.js');
    wp_enqueue_script('fancybox', get_template_directory_uri() . '/scripts/fancybox.min.js');

    wp_enqueue_script('slider-config', get_template_directory_uri() . '/scripts/develop/slider-config.js');
    wp_enqueue_script('customjs', get_template_directory_uri() . '/scripts/custom.js');

    // AJAX на товарі
    wp_enqueue_script('product-ajax', get_template_directory_uri() . '/scripts/product-ajax.js');
    // AJAX на пошук
    wp_enqueue_script('form-find-ajax', get_template_directory_uri() . '/scripts/form-find-ajax.js');
}
