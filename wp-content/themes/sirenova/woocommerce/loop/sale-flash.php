<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php
// Ініціалізація змінної sale_text
$sale_text = '';

// Отримання кастомних цін
$custom_price = floatval(get_field('sirenova_price', get_the_ID()));
$custom_sale_price = floatval(get_field('sirenova_sale_price', get_the_ID()));

// Розрахунок знижки
if ($custom_price > 0 && $custom_sale_price > 0 && $custom_sale_price < $custom_price) {
	$discount_percentage = (($custom_price - $custom_sale_price) / $custom_price) * 100;
	$sale_text = sprintf('-%d%%', round($discount_percentage));
}

// Друк плашки знижки
if ($sale_text) {
	echo apply_filters('woocommerce_sale_flash', '<span class="onsale">' . $sale_text . '</span>', $post, $product);
}





/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */