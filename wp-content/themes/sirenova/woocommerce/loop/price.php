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
	<?php if ($min_regular_price && $min_regular_price != $min_sale_price) : ?>
		<span class="old-price"><?php echo custom_price_format(wc_price($min_regular_price), $product); ?></span>
	<?php endif; ?>
	<a href="<?php the_permalink(); ?>" class="btn product__buy">
		<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M13.5001 12.9663L12.6412 3.29448C12.6228 3.07975 12.4419 2.91718 12.2302 2.91718H10.4633C10.4388 1.30368 9.11977 0 7.50014 0C5.88051 0 4.56149 1.30368 4.53695 2.91718H2.77008C2.55535 2.91718 2.37744 3.07975 2.35903 3.29448L1.50014 12.9663C1.50014 12.9785 1.49707 12.9908 1.49707 13.0031C1.49707 14.1043 2.50627 15 3.7486 15H11.2517C12.494 15 13.5032 14.1043 13.5032 13.0031C13.5032 12.9908 13.5032 12.9785 13.5001 12.9663ZM7.50014 0.828221C8.66271 0.828221 9.61057 1.76074 9.63511 2.91718H5.36517C5.38971 1.76074 6.33756 0.828221 7.50014 0.828221ZM11.2517 14.1718H3.7486C2.96946 14.1718 2.33756 13.6564 2.32529 13.0215L3.14738 3.74847H4.53388V5.00613C4.53388 5.2362 4.71793 5.42025 4.94799 5.42025C5.17805 5.42025 5.3621 5.2362 5.3621 5.00613V3.74847H9.63511V5.00613C9.63511 5.2362 9.81916 5.42025 10.0492 5.42025C10.2793 5.42025 10.4633 5.2362 10.4633 5.00613V3.74847H11.8498L12.675 13.0215C12.6627 13.6564 12.0277 14.1718 11.2517 14.1718Z" fill="white"></path>
		</svg>
	</a>
</div>