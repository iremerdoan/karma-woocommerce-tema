<?php
/**
 * Karma teması — temel ayarlar.
 */

defined( 'ABSPATH' ) || exit;

define( 'KARMA_VERSION', '1.0.0' );
define( 'KARMA_DIR', get_template_directory() );
define( 'KARMA_URI', get_template_directory_uri() );

require KARMA_DIR . '/inc/icons.php';
require KARMA_DIR . '/inc/helpers.php';
require KARMA_DIR . '/inc/customizer.php';

if ( class_exists( 'WooCommerce' ) ) {
	require KARMA_DIR . '/inc/woocommerce.php';
	require KARMA_DIR . '/inc/kurulum.php';
}

/**
 * Tema özellikleri ve menü konumları.
 */
add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'karma', KARMA_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );

	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 600,  // ürün kartı (276×330 → 2x)
		'single_image_width'    => 1320, // ürün sayfası ana görsel (660px → 2x)
		'product_grid'          => array( 'default_columns' => 4, 'default_rows' => 3 ),
	) );

	register_nav_menus( array(
		'ana-menu'        => __( 'Ana menü (üst)', 'karma' ),
		'alt-alisveris'   => __( 'Alt bilgi: Alışveriş', 'karma' ),
		'alt-yardim'      => __( 'Alt bilgi: Yardım', 'karma' ),
	) );
} );

/**
 * Stil ve betikler.
 */
add_action( 'wp_enqueue_scripts', function () {
	// Yazı tipleri: Cormorant Garamond (başlıklar) + DM Sans (metin).
	wp_enqueue_style(
		'karma-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&display=swap',
		array(),
		null
	);

	$css = KARMA_DIR . '/assets/css/app.css';
	wp_enqueue_style( 'karma', KARMA_URI . '/assets/css/app.css', array(), file_exists( $css ) ? filemtime( $css ) : KARMA_VERSION );

	$js = KARMA_DIR . '/assets/js/app.js';
	wp_enqueue_script( 'karma', KARMA_URI . '/assets/js/app.js', array(), file_exists( $js ) ? filemtime( $js ) : KARMA_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
} );

/** Google Fonts bağlantısını hızlandır. */
add_filter( 'wp_resource_hints', function ( $urls, $type ) {
	if ( 'preconnect' === $type ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		$urls[] = 'https://fonts.googleapis.com';
	}
	return $urls;
}, 10, 2 );
