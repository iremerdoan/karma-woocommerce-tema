<?php
/**
 * WooCommerce uyarlamaları.
 */

defined( 'ABSPATH' ) || exit;

/* Kenar çubuğu yok; sayfa sarmalayıcıları woocommerce.php içinde. */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/* Sayfa yolu: "Ana Sayfa / Kadın / Keten Gömlek" */
add_filter( 'woocommerce_breadcrumb_defaults', function () {
	return array(
		'delimiter'   => '<span class="text-ikincil" aria-hidden="true">/</span>',
		'wrap_before' => '<nav class="flex flex-wrap items-center gap-2 text-kucuk text-ikincil [&>a:hover]:text-espresso" aria-label="' . esc_attr__( 'Sayfa yolu', 'karma' ) . '">',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => __( 'Ana Sayfa', 'karma' ),
	);
} );

/* Mağaza: satır başına 4 ürün, sayfada 12 ürün. */
add_filter( 'loop_shop_columns', fn() => 4 );
add_filter( 'loop_shop_per_page', fn() => 12 );

/* Benzer ürünler: 4 tane. */
add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
} );

/* Sepet ikonundaki ürün sayısı, sayfa yenilenmeden güncellensin. */
function karma_sepet_sayaci() {
	$adet = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	printf(
		'<span class="karma-sepet-sayac absolute right-1 top-1 flex size-[18px] items-center justify-center rounded-full bg-karamel text-[11px] font-semibold text-white %s">%d</span>',
		$adet ? '' : 'hidden',
		(int) $adet
	);
}
add_filter( 'woocommerce_add_to_cart_fragments', function ( $parcalar ) {
	ob_start();
	karma_sepet_sayaci();
	$parcalar['span.karma-sepet-sayac'] = ob_get_clean();
	return $parcalar;
} );

/* Ürün düzenleme ekranına "Kumaş ve bakım" alanı. */
add_action( 'woocommerce_product_options_general_product_data', function () {
	echo '<div class="options_group">';
	woocommerce_wp_textarea_input( array(
		'id'          => '_karma_kumas_bakim',
		'label'       => __( 'Kumaş ve bakım', 'karma' ),
		'placeholder' => __( 'Örn. %100 keten. 30°C\'de yıkayın, ters ütüleyin.', 'karma' ),
		'desc_tip'    => true,
		'description' => __( 'Ürün sayfasındaki "Kumaş ve bakım" bölümünde görünür.', 'karma' ),
	) );
	echo '</div>';
} );
add_action( 'woocommerce_admin_process_product_object', function ( WC_Product $urun ) {
	if ( isset( $_POST['_karma_kumas_bakim'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification -- WooCommerce kaydı kendi nonce'unu doğrular.
		$urun->update_meta_data( '_karma_kumas_bakim', sanitize_textarea_field( wp_unslash( $_POST['_karma_kumas_bakim'] ) ) );
	}
} );

/* Varyasyon seçimi: "Bir seçenek belirleyin" yerine boş başlık (butonlara dönüştürülüyor). */
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', function ( $args ) {
	$args['show_option_none'] = __( 'Seçin', 'karma' );
	return $args;
} );

/* Ürün kartında kategori adı (Kadın / Erkek). */
function karma_urun_ust_kategori( $urun ) {
	$terimler = get_the_terms( $urun->get_id(), 'product_cat' );
	if ( ! $terimler || is_wp_error( $terimler ) ) {
		return '';
	}
	foreach ( $terimler as $t ) {
		if ( 0 === (int) $t->parent ) {
			return $t->name;
		}
	}
	return $terimler[0]->name;
}

/* Mağaza / kategori sayfası başlık alanı. */
add_filter( 'woocommerce_show_page_title', '__return_false' );
