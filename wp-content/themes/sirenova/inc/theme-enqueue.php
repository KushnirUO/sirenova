<?php
add_action('wp_enqueue_scripts', 'sirenova_scripts');

function sirenova_scripts()
{

    wp_enqueue_style('dev_0_basic',  get_template_directory_uri() . '/style/dev_0_basic.css');
    wp_enqueue_style('dev_1',  get_template_directory_uri() . '/style/dev_1.css');
    wp_enqueue_style('normalize',  get_template_directory_uri() . '/style/normalize.css');
    wp_enqueue_style('responsive',  get_template_directory_uri() . '/style/responsive.css');
    wp_enqueue_style('customcss',  get_template_directory_uri() . '/style/custom.css');

    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/scripts/jquery-3.7.1.min.js');
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-new', get_template_directory_uri() . '/scripts/jquery-3.7.1.min.js');


    wp_enqueue_script('customjs', get_template_directory_uri() . '/scripts/custom.js');
}
