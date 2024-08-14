<?php
// Фільтр для форматування цін
add_filter('woocommerce_get_price_html', 'custom_price_format', 100, 2);

function custom_price_format($price, $product)
{
    // Видалення копійок і заміна знака гривні на "грн"
    $price = preg_replace('/,00/', '', $price);
    $price = str_replace(get_woocommerce_currency_symbol(), 'грн', $price);
    return $price;
}
;