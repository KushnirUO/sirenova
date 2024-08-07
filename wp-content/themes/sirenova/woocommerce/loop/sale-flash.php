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
$sale_text = ''; // Ініціалізація змінної sale_text

// Перевірка типу продукту
if ($product->is_type('variable')) {
	$available_variations = $product->get_available_variations();
	$max_discount = 0;

	foreach ($available_variations as $variation) {
		$variation_obj = new WC_Product_Variation($variation['variation_id']);
		$variation_custom_price = floatval(get_field('sirenova_price', $variation['variation_id']));
		$variation_custom_sale_price = floatval(get_field('sirenova_sale_price', $variation['variation_id']));
		$variation_regular_price = floatval($variation_obj->get_regular_price());
		$variation_sale_price = floatval($variation_obj->get_sale_price());

		// Використання кастомних цін, якщо вони заповнені
		$regular_price = $variation_custom_price > 0 ? $variation_custom_price : $variation_regular_price;
		$sale_price = $variation_custom_sale_price > 0 ? $variation_custom_sale_price : $variation_sale_price;

		// Перевірка наявності ціни зі знижкою
		if ($regular_price > 0 && $sale_price > 0 && $sale_price < $regular_price) {
			$discount_percentage = (($regular_price - $sale_price) / $regular_price) * 100;
			$max_discount = max($max_discount, $discount_percentage);
		}
	}

	if ($max_discount > 0) {
		$sale_text = sprintf('-%d%%', round($max_discount));
	}
} else {
	$product_custom_price = floatval(get_field('sirenova_price', $product->get_id()));
	$product_custom_sale_price = floatval(get_field('sirenova_sale_price', $product->get_id()));
	$product_regular_price = floatval($product->get_regular_price());
	$product_sale_price = floatval($product->get_sale_price());

	$regular_price = $product_custom_price > 0 ? $product_custom_price : $product_regular_price;
	$sale_price = $product_custom_sale_price > 0 ? $product_custom_sale_price : $product_sale_price;

	if ($regular_price > 0 && $sale_price > 0 && $sale_price < $regular_price) {
		$discount_percentage = (($regular_price - $sale_price) / $regular_price) * 100;
		$sale_text = sprintf('-%d%%', round($discount_percentage));
	}
}

// Друк плашки знижки
if ($sale_text) {
	echo apply_filters('woocommerce_sale_flash', '<span class="onsale">' . $sale_text . '</span>', $post, $product);
} else {
	// Для перевірки, чи плашка відображається
	echo '<span class="onsale">No Discount</span>';
}



/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */