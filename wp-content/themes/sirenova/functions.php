<?php

// Hide admin bar
show_admin_bar(true);

// Custom Theme decklaration
add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
}, 20);

// Add ACF Option page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
};

function set_sale_page_flag()
{
    if (is_page_template('template-sale.php')) {
        global $is_sale_page;
        $is_sale_page = true;
    }
}
add_action('wp', 'set_sale_page_flag');


// Підключення скриптів та стилів
require_once get_template_directory() . '/inc/theme-enqueue.php';
// Реєстрація списків меню
require_once get_template_directory() . '/inc/sirenova-register-menus.php';
// Підключення Header_Menu_Walker
require_once get_template_directory() . '/inc/classes/class-sirenova-header-menu.php';
// Підключення Footer_Menu_Walker
require_once get_template_directory() . '/inc/classes/class-sirenova-footer-menu.php';
// Видалення хуків woocommerce
require_once get_template_directory() . '/inc/woocommerce/sirenova-remove-action.php';
// Вибір кольору для атрибуту колір в адмінці
require_once get_template_directory() . '/inc/woocommerce/sirenova-color-picker.php';
// Пошук
require_once get_template_directory() . '/inc/search/sirenova-search-ajax.php';
// Пошук на сторінці магазину
require_once get_template_directory() . '/inc/search/sirenova-shop-search.php';
// Корзина та міні-корзина
require_once get_template_directory() . '/inc/cart/sirenova-cart-ajax.php';
// Додати товару в корзину
require_once get_template_directory() . '/inc/woocommerce/sirenova-add-to-cart-ajax.php';
// Кастомний формат цін
require_once get_template_directory() . '/inc/woocommerce/sirenova-custom-format-price.php';
// Кастомне поле цін
require_once get_template_directory() . '/inc/woocommerce/sirenova-custom-prices.php';
// Знижка на всі товари - NO READY!!!!!!!!!!
require_once get_template_directory() . '/inc/woocommerce/sirenova-discount-products.php';
// AJAX на фільтр магазину
require_once get_template_directory() . '/inc/woocommerce/sirenova-shop-filter-ajax.php';
// Отримати кількість товарів в магазині і категорії
require_once get_template_directory() . '/inc/woocommerce/sirenova-get-products-count.php';
// Дозвіл загружати і відображати SVG
require_once get_template_directory() . '/inc/sirenova-allow-svg.php';
// AJAX сортування магазину
// require_once get_template_directory() . '/inc/woocommerce/sirenova-ordering-ajax.php';
// AJAX wishlist
require_once get_template_directory() . '/inc/woocommerce/sirenova-wishlist-ajax.php';

// Заборона шорткодам виводити товари не в наявності
add_filter('woocommerce_shortcode_products_query', 'exclude_out_of_stock_from_shortcode');

function exclude_out_of_stock_from_shortcode($args)
{
    // Додаємо meta_query для виключення товарів, яких немає в наявності
    $args['meta_query'][] = array(
        'key' => '_stock_status',
        'value' => 'instock',
        'compare' => '='
    );
    return $args;
}

// Отримати кількість товарів зі знижкою
function get_total_discounted_products_count()
{
    // Отримуємо ID всіх товарів, які зараз на знижці
    $on_sale_products = wc_get_product_ids_on_sale();

    // Фільтруємо тільки батьківські продукти
    $parent_products_count = 0;

    foreach ($on_sale_products as $product_id) {
        $product = wc_get_product($product_id);

        if ($product && $product->is_type('simple') || $product->is_type('variable')) {
            $parent_products_count++;
        }
    }

    return $parent_products_count;
}

// Додати блок оплати у col-2
add_action('woocommerce_checkout_shipping', 'woocommerce_checkout_payment', 20);
// Видалення полів checkout
add_filter('woocommerce_cart_needs_shipping_address', '__return_false');
add_filter('woocommerce_billing_fields', 'custom_remove_billing_fields');

function custom_remove_billing_fields($fields)
{

    unset($fields['billing_company']);
    unset($fields['billing_address_1']);
    unset($fields['billing_address_2']);
    unset($fields['billing_city']);
    unset($fields['billing_postcode']);
    unset($fields['billing_state']);

    return $fields;
}

// Додати заголовок в блок оплати
add_action('woocommerce_review_order_before_payment', 'add_payment_heading');
function add_payment_heading()
{
    echo '<h3>Виберіть спосіб оплати:</h3>';
}

// Видаляємо поле реєстрації облікового запису
add_filter('woocommerce_checkout_fields', 'remove_account_fields');
function remove_account_fields($fields)
{
    unset($fields['account']);
    return $fields;
}

// Видаляем адресу доставки з thankyou-page
add_action('woocommerce_thankyou', 'remove_shipping_address_column', 1);

function remove_shipping_address_column()
{
?>
    <style>
        .woocommerce-column.woocommerce-column--2.woocommerce-column--shipping-address.col-2 {
            display: none !important;
        }
    </style>
<?php
}

// Переміщення товарів без наявності в кінець списку і сортування по новизні
function custom_sort_out_of_stock_to_end_and_by_date($query)
{
    if (!is_admin() && $query->is_main_query() && (is_shop() || is_product_category() || is_product_tag() || is_sale_page())) {
        // Додаємо мета-запит для сортування за наявністю
        $meta_query = $query->get('meta_query');

        $meta_query[] = array(
            'relation' => 'OR',
            array(
                'key' => '_stock_status',
                'value' => 'instock',
                'compare' => '=',
            ),
            array(
                'key' => '_stock_status',
                'value' => 'outofstock',
                'compare' => '=',
            ),
        );

        $query->set('meta_query', $meta_query);

        // Сортування: спочатку по новизні, потім по наявності
        $query->set('orderby', array(
            'meta_value' => 'ASC',  // Сортування за наявністю
            'date' => 'DESC', // Сортування по новизні
        ));
    }
}
add_action('pre_get_posts', 'custom_sort_out_of_stock_to_end_and_by_date');

// Перевірка, чи це сторінка sale (розпродаж)
function is_sale_page()
{
    return is_page() && get_the_ID() === wc_get_page_id('sale');
}



// Додаємо хук на сторінку "Дякую"
add_action('woocommerce_thankyou', 'redirect_to_wayforpay_if_cod', 10, 1);

function redirect_to_wayforpay_if_cod($order_id)
{
    $order = wc_get_order($order_id);

    // Перевіряємо, чи метод оплати "Готівка при отриманні"
    if ('cod' === $order->get_payment_method()) {
        // Фіксована сума для WayForPay
        $amount = 10;

        // Генеруємо посилання для редиректу на WayForPay
        $wayforpay_form = generate_wayforpay_payment_form($order_id, $amount);

        // Виводимо форму для оплати та автоматично відправляємо її
        echo $wayforpay_form;

        // Зупиняємо подальше виконання коду, щоб уникнути редиректу на стандартну сторінку "Дякую"
        exit;
    }
}

function generate_signature($merchantAccount, $orderReference, $orderDate, $amount, $currency, $orderTimeout, $productName, $productPrice, $productCount, $clientFirstName, $clientLastName, $clientAddress, $clientCity, $clientEmail, $clientPhone, $clientCountry, $clientRegion, $merchantDomainName, $defaultPaymentSystem, $secretKey)
{
    $signatureString = implode(';', array(
        $merchantAccount,
        $merchantDomainName,
        $orderReference,
        $orderDate,
        $amount,
        $currency,
        $productName,
        $productCount,
        $productPrice,
    ));
    // return $signatureString;

    return hash_hmac('md5', $signatureString, $secretKey);
}
function generate_wayforpay_payment_form($order_id, $amount)
{
    $order = wc_get_order($order_id);

    // Основні параметри WayForPay
    $merchantAccount = 'test_merch_n1';
    $secretKey = 'flk3409refn54t54t*FNJRET';
    $currency = 'UAH';
    $productName = 'Фіксована оплата';
    $productCount = 1;
    $productPrice = $amount;
    $orderDate = time();
    $clientEmail = $order->get_billing_email();
    $clientFirstName = $order->get_billing_first_name();
    $clientLastName = $order->get_billing_last_name();
    $clientAddress = $order->get_billing_address_1();
    $clientCity = $order->get_billing_city();
    $clientPhone = $order->get_billing_phone(); // Якщо потрібно
    $clientCountry = ''; // Якщо потрібно
    $clientRegion = ''; // Якщо потрібно
    $merchantDomainName =
        parse_url(home_url(), PHP_URL_HOST);
    $orderTimeout = '49000';
    $defaultPaymentSystem = 'card';
    $merchantTransactionSecureType = 'AUTO'; // Доданий параметр безпеки
    // $returnUrl = $thank_you_page_url;


    // Генерація підпису для WayForPay
    $signature = generate_signature(
        $merchantAccount,
        $order_id,
        $orderDate,
        $amount,
        $currency,
        $orderTimeout,
        $productName,
        $productPrice,
        $productCount,
        $clientFirstName,
        $clientLastName,
        $clientAddress,
        $clientCity,
        $clientEmail,
        $clientPhone,
        $clientCountry,
        $clientRegion,
        $merchantDomainName,
        $defaultPaymentSystem,
        $secretKey
    );

    // URL для повернення на сайт після успішної оплати
    $returnUrl = add_query_arg('key', $order->get_order_key(), $order->get_checkout_order_received_url());
    // Генерація HTML форми для WayForPay
    $form = '<form method="post" action="https://secure.wayforpay.com/pay" id="wayforpay_payment_form" accept-charset="utf-8" style="display:none">';
    $form .= '<input name="merchantAccount" value="' . esc_attr($merchantAccount) . '">';
    $form .= '<input name="merchantAuthType" value="SimpleSignature">';
    $form .= '<input name="merchantDomainName" value="' . esc_attr($merchantDomainName) . '">';
    $form .= '<input name="orderReference" value="' . esc_attr($order_id) . '">';
    $form .= '<input name="orderDate" value="' . esc_attr($orderDate) . '">';
    $form .= '<input name="amount" value="' . esc_attr($amount) . '">';
    $form .= '<input name="currency" value="' . esc_attr($currency) . '">';
    $form .= '<input name="orderTimeout" value="' . esc_attr($orderTimeout) . '">';

    $form .= '<input name="productName[]" value="' . esc_attr($productName) . '">';
    $form .= '<input name="productPrice[]" value="' . esc_attr($productPrice) . '">';
    $form .= '<input name="productCount[]" value="' . esc_attr($productCount) . '">';

    $form .= '<input name="clientFirstName" value="' . esc_attr($clientFirstName) . '">';
    $form .= '<input name="clientLastName" value="' . esc_attr($clientLastName) . '">';
    $form .= '<input name="clientAddress" value="' . esc_attr($clientAddress) . '">';
    $form .= '<input name="clientCity" value="' . esc_attr($clientCity) . '">';
    $form .= '<input name="clientEmail" value="' . esc_attr($clientEmail) . '">';
    $form .= '<input name="clientPhone" value="' . esc_attr($clientPhone) . '">'; // Якщо потрібно
    $form .= '<input name="clientCountry" value="' . esc_attr($clientCountry) . '">'; // Якщо потрібно
    $form .= '<input name="clientRegion" value="' . esc_attr($clientRegion) . '">'; // Якщо потрібно
    $form .= '<input name="defaultPaymentSystem" value="' . esc_attr($defaultPaymentSystem) . '">';
    $form .= '<input name="merchantSignature" value="' . esc_attr($signature) . '">';
    $form .= '<input name="merchantTransactionSecureType" value="' . esc_attr($merchantTransactionSecureType) . '">';
    $form .= '<input name="returnUrl" value="' . esc_attr($returnUrl) . '">';


    $form .= '<input type="submit" value="Оплатити">';
    $form .= '</form>';
    $form .= '<script type="text/javascript">
                document.getElementById("wayforpay_payment_form").submit();
              </script>';
    return $form;
}
