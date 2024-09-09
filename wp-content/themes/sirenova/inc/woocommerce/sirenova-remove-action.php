<?php
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

// Видалення хуків woocommerce
// Видалити блок оплати з поточного місця
remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
// Видалення інформаційних повідомлень на сторінці оформлення замовлення
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10);