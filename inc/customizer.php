<?php
/**
 * Görünüm → Özelleştir → "Karma Ayarları"
 * Tasarımdaki [X] alanları ve ana sayfa görselleri buradan değiştirilir.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', function ( WP_Customize_Manager $wp ) {
	$v = karma_varsayilanlar();

	$wp->add_panel( 'karma', array( 'title' => __( 'Karma Ayarları', 'karma' ), 'priority' => 30 ) );

	$bolumler = array(
		'karma_genel'    => __( 'Kargo, iade ve kampanya', 'karma' ),
		'karma_hero'     => __( 'Ana sayfa: Giriş (hero)', 'karma' ),
		'karma_gorseller'=> __( 'Ana sayfa: Görseller', 'karma' ),
		'karma_sosyal'   => __( 'Sosyal medya', 'karma' ),
	);
	foreach ( $bolumler as $id => $baslik ) {
		$wp->add_section( $id, array( 'title' => $baslik, 'panel' => 'karma' ) );
	}

	$metin = function ( $id, $etiket, $bolum, $tur = 'text', $temizle = 'sanitize_text_field' ) use ( $wp, $v ) {
		$wp->add_setting( $id, array( 'default' => $v[ $id ], 'sanitize_callback' => $temizle ) );
		$wp->add_control( $id, array( 'label' => $etiket, 'section' => $bolum, 'type' => $tur ) );
	};
	$gorsel = function ( $id, $etiket, $bolum ) use ( $wp ) {
		$wp->add_setting( $id, array( 'default' => '', 'sanitize_callback' => 'absint' ) );
		$wp->add_control( new WP_Customize_Media_Control( $wp, $id, array(
			'label'     => $etiket,
			'section'   => $bolum,
			'mime_type' => 'image',
		) ) );
	};

	$metin( 'kargo_limiti', __( 'Ücretsiz kargo limiti (TL)', 'karma' ), 'karma_genel', 'number', 'absint' );
	$metin( 'iade_gun', __( 'Kolay iade süresi (gün)', 'karma' ), 'karma_genel', 'number', 'absint' );
	$metin( 'kargo_iade_metni', __( 'Ürün sayfası "Kargo ve iade" metni', 'karma' ), 'karma_genel', 'textarea', 'sanitize_textarea_field' );
	$metin( 'kampanya_goster', __( 'Sezon sonu indirimi bölümünü göster', 'karma' ), 'karma_genel', 'checkbox', 'wp_validate_boolean' );
	$metin( 'indirim_orani', __( 'İndirim oranı (%)', 'karma' ), 'karma_genel', 'number', 'absint' );
	$metin( 'kampanya_link', __( '"Fırsatları Keşfet" bağlantısı (boşsa İndirim kategorisi)', 'karma' ), 'karma_genel', 'url', 'esc_url_raw' );

	$metin( 'hero_ust', __( 'Üst etiket', 'karma' ), 'karma_hero' );
	$metin( 'hero_baslik', __( 'Başlık', 'karma' ), 'karma_hero' );
	$metin( 'hero_metin', __( 'Açıklama', 'karma' ), 'karma_hero', 'textarea', 'sanitize_textarea_field' );
	$gorsel( 'hero_gorsel', __( 'Giriş görseli (dikey, ~940×1200)', 'karma' ), 'karma_hero' );

	$gorsel( 'kampanya_gorsel', __( 'İndirim kampanyası görseli (~1040×970)', 'karma' ), 'karma_gorseller' );
	$gorsel( 'kat_kadin_gorsel', __( 'Kategori: Kadın (~770×720)', 'karma' ), 'karma_gorseller' );
	$gorsel( 'kat_erkek_gorsel', __( 'Kategori: Erkek (~770×720)', 'karma' ), 'karma_gorseller' );
	$gorsel( 'kat_yeni_gorsel', __( 'Kategori: Yeni Gelenler (~770×720)', 'karma' ), 'karma_gorseller' );

	$metin( 'instagram', __( 'Instagram adresi', 'karma' ), 'karma_sosyal', 'url', 'esc_url_raw' );
	$metin( 'tiktok', __( 'TikTok adresi', 'karma' ), 'karma_sosyal', 'url', 'esc_url_raw' );
} );
