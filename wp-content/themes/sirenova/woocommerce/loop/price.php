<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
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

global $product;
?>
<?php
// Product price
// Отримання кастомних цін
$custom_price = floatval(get_field('sirenova_price', get_the_ID()));
$custom_sale_price = floatval(get_field('sirenova_sale_price', get_the_ID()));

if (!$product) {
	$product = wc_get_product(get_the_ID());
}

// Якщо товар варіативний, використовуємо кастомні ціни
if ($product && $product->is_type('variable')) {
	$min_regular_price = $custom_price > 0 ? $custom_price : '';
	$min_sale_price = $custom_sale_price > 0 ? $custom_sale_price : $min_regular_price;
} else {
	// Якщо не варіативний товар, використовуємо кастомні ціни
	$min_regular_price = $custom_price > 0 ? $custom_price : floatval($product->get_regular_price());
	$min_sale_price = $custom_sale_price > 0 ? $custom_sale_price : floatval($product->get_sale_price());
}
?>

<div class="product__price">
	<span><?php echo custom_price_format(wc_price($min_sale_price), $product); ?></span>
	<?php if ($min_regular_price && $min_regular_price != $min_sale_price): ?>
		<span class="old-price"><?php echo custom_price_format(wc_price($min_regular_price), $product); ?></span>
	<?php endif; ?>
</div>