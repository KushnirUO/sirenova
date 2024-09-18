<?php
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

function generate_signature(
    $merchantAccount,
    $orderReference,
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
) {
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
    $form = '<form method="post" action="https://secure.wayforpay.com/pay" id="wayforpay_payment_form"
    accept-charset="utf-8" style="display:none">';
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
    $form .= '<input name="serviceUrl" value="' . esc_attr(home_url('/wayforpay-callback')) . '">';


    $form .= '<input type="submit" value="Оплатити">';
    $form .= '</form>';
    $form .= '
<script type="text/javascript">
    document.getElementById("wayforpay_payment_form").submit();
</script>';
    return $form;
}






// Примусово встановлюємо статус "Очікує оплати" для замовлень з оплатою "Готівка при отриманні"
add_filter('woocommerce_cod_process_payment_order_status', 'set_cod_order_status_to_pending', 10, 2);
function set_cod_order_status_to_pending($status, $order)
{
    // Перевіряємо, чи це замовлення для оплати готівкою
    if ($order->get_payment_method() === 'cod') {
        return 'pending'; // Встановлюємо статус "Очікує оплати"
    }

    return $status;
}


add_action('init', 'handle_wayforpay_service_url');
function handle_wayforpay_service_url()
{
    if (isset($_POST['merchantSignature']) && isset($_POST['orderReference'])) {
        $order_id = sanitize_text_field($_POST['orderReference']);
        $response_status = sanitize_text_field($_POST['transactionStatus']); // Статус транзакції

        // Обробка отриманого статусу
        handle_payment_gateway_response($response_status, $order_id);

        // Відправлення відповіді WayForPay для підтвердження отримання даних
        $response = array(
            'orderReference' => $order_id,
            'status' => 'accept',
            'time' => time(),
        );
        echo json_encode($response);
        exit;
    }
}

// Оновлення статусу замовлення на основі відповіді
function handle_payment_gateway_response($response, $order_id)
{
    $order = wc_get_order($order_id);

    switch ($response) {
        case 'InProcessing':
        case 'WaitingAuthComplete':
        case 'Pending':
            $order->update_status('wc-pending'); // Очікує оплати
            break;
        case 'Approved':
            $order->update_status('wc-processing'); // В обробці
            break;
        case 'Expired':
        case 'Declined':
            $order->update_status('wc-failed'); // Не вдалося
            break;
        case 'Refunded':
        case 'Voided':
        case 'RefundInProcessing':
            $order->update_status('wc-cancelled'); // Скасовано
            break;
    }

    // Додаткові дії, наприклад, надсилання електронних листів тощо
}