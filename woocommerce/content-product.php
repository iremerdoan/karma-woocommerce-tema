<?php
/**
 * Mağaza ve kategori listelerinde ürün kartı.
 * WooCommerce şablonunun Karma sürümü.
 *
 * @version 3.6.0
 */
defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'list-none', $product ); ?>>
	<?php get_template_part( 'template-parts/urun-karti', null, array( 'urun' => $product ) ); ?>
</li>
