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
$custom_price = floatval(get_field('sirenova_price', $product->get_id()));
$custom_sale_price = floatval(get_field('sirenova_sale_price', $product->get_id()));

if (!$product) {
	$product = wc_get_product(get_the_ID());
}

if ($product && $product->is_type('variable')) {
	$available_variations = $product->get_available_variations();
	$regular_prices = array();
	$sale_prices = array();

	foreach ($available_variations as $variation) {
		$variation_obj = new WC_Product_Variation($variation['variation_id']);
		$variation_regular_price = floatval($variation_obj->get_regular_price());
		$variation_sale_price = floatval($variation_obj->get_sale_price());

		// Використання ціни варіації, якщо вона не пуста або 0
		$regular_prices[] = $variation_regular_price > 0 ? $variation_regular_price : null;
		$sale_prices[] = $variation_sale_price > 0 ? $variation_sale_price : null;
	}

	// Визначення мінімальних цін з варіацій
	if (!empty($regular_prices)) {
		$min_regular_price = min(array_filter($regular_prices));
	} else {
		$min_regular_price = null;
	}

	if (!empty($sale_prices)) {
		$min_sale_price = min(array_filter($sale_prices));
	} else {
		$min_sale_price = null;
	}
} else {
	// Якщо не варіативний товар, використовуємо кастомні ціни
	$min_regular_price = $custom_price > 0 ? $custom_price : floatval($product->get_regular_price());
	$min_sale_price = $custom_sale_price > 0 ? $custom_sale_price : floatval($product->get_sale_price());
}

// Якщо ціна варіації пуста або 0, використовуємо кастомні ціни
if (!isset($min_regular_price) || $min_regular_price <= 0) {
	$min_regular_price = $custom_price > 0 ? $custom_price : '';
}

if (!isset($min_sale_price) || $min_sale_price <= 0) {
	$min_sale_price = $custom_sale_price > 0 ? $custom_sale_price : $min_regular_price;
}
?>

<div class="product__price">
	<span><?php echo custom_price_format(wc_price($min_sale_price), $product); ?></span>
	<?php if ($min_regular_price && $min_regular_price != $min_sale_price): ?>
		<span class="old-price"><?php echo custom_price_format(wc_price($min_regular_price), $product); ?></span>
	<?php endif; ?>
</div>