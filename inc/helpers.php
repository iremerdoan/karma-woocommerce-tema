<?php
/**
 * Yardımcı fonksiyonlar.
 */

defined( 'ABSPATH' ) || exit;

/** Özelleştirici ayarını varsayılanıyla oku. */
function karma_ayar( $anahtar ) {
	$varsayilan = karma_varsayilanlar();
	return get_theme_mod( $anahtar, $varsayilan[ $anahtar ] ?? '' );
}

function karma_varsayilanlar() {
	return array(
		'kargo_limiti'     => '1500',
		'iade_gun'         => '14',
		'indirim_orani'    => '50',
		'hero_ust'         => 'Yeni Sezon',
		'hero_baslik'      => 'Kendini iyi hisset, kendin gibi giyin.',
		'hero_metin'       => 'Kadın ve erkek için sade, rahat ve uzun ömürlü parçalar.',
		'hero_gorsel'      => '',
		'kampanya_goster'  => true,
		'kampanya_gorsel'  => '',
		'kampanya_link'    => '',
		'kat_kadin_gorsel' => '',
		'kat_erkek_gorsel' => '',
		'kat_yeni_gorsel'  => '',
		'kargo_iade_metni' => 'Siparişler 1-3 iş günü içinde kargoya verilir. Ürünü teslim aldıktan sonra 14 gün içinde ücretsiz iade edebilirsin.',
		'instagram'        => '',
		'tiktok'           => '',
	);
}

/** "[X] TL üzeri ücretsiz kargo · [X] gün içinde kolay iade" */
function karma_duyuru_metni() {
	return sprintf(
		/* translators: 1: TL tutarı 2: gün */
		__( '%1$s TL üzeri ücretsiz kargo · %2$s gün içinde kolay iade', 'karma' ),
		karma_tl( karma_ayar( 'kargo_limiti' ) ),
		karma_ayar( 'iade_gun' )
	);
}

/** Ürün kategorisi bağlantısı (yoksa mağaza sayfası). */
function karma_kategori_linki( $slug ) {
	if ( taxonomy_exists( 'product_cat' ) ) {
		$terim = get_term_by( 'slug', $slug, 'product_cat' );
		if ( $terim && ! is_wp_error( $terim ) ) {
			return get_term_link( $terim );
		}
	}
	return karma_magaza_linki();
}

function karma_magaza_linki( $sorgu = array() ) {
	$url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
	return $sorgu ? add_query_arg( $sorgu, $url ) : $url;
}

/** Ana menü boşken kullanılacak bağlantılar (Figma'daki sıra). 4. alan: alt kategorileri gösterilecek kategori. */
function karma_varsayilan_menu() {
	return array(
		array( 'Kadın', karma_kategori_linki( 'kadin' ), false, 'kadin' ),
		array( 'Erkek', karma_kategori_linki( 'erkek' ), false, 'erkek' ),
		array( 'Yeni Gelenler', karma_magaza_linki( array( 'orderby' => 'date' ) ), false, '' ),
		array( 'İndirim', karma_kategori_linki( 'indirim' ), true, '' ),
	);
}

/**
 * Bir ürün kategorisinin alt kategorileri (ör. Kadın → Elbise, Tişört, Pantolon).
 * Sıra: Ürünler → Kategoriler ekranındaki sürükle-bırak sırası.
 */
function karma_alt_kategoriler( $ust ) {
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		return array();
	}
	$ust_terim = is_object( $ust ) ? $ust : get_term_by( 'slug', $ust, 'product_cat' );
	if ( ! $ust_terim || is_wp_error( $ust_terim ) ) {
		return array();
	}
	$cocuklar = get_terms( array(
		'taxonomy'   => 'product_cat',
		'parent'     => $ust_terim->term_id,
		'hide_empty' => false,
		'orderby'    => 'menu_order',
	) );
	return is_wp_error( $cocuklar ) ? array() : $cocuklar;
}

/**
 * Ana menüyü yazdır. WordPress menüsü atanmışsa onu, yoksa varsayılanı kullanır.
 * $mobil = true → dikey liste. Kadın / Erkek altında alt kategoriler açılır.
 */
function karma_ana_menu( $mobil = false ) {
	$ul = $mobil ? 'flex flex-col' : 'flex items-center gap-8';
	$a  = $mobil ? 'block py-3 text-[22px] font-serif font-medium' : 'text-normal font-medium hover:text-karamel';

	if ( has_nav_menu( 'ana-menu' ) ) {
		wp_nav_menu( array(
			'theme_location' => 'ana-menu',
			'container'      => false,
			'menu_class'     => $ul,
			'depth'          => 1,
			'link_class'     => $a,
		) );
		return;
	}

	echo '<ul class="' . esc_attr( $ul ) . '">';
	foreach ( karma_varsayilan_menu() as $oge ) {
		$renk  = $oge[2] ? 'text-karamel' : 'text-espresso';
		$altlar = $oge[3] ? karma_alt_kategoriler( $oge[3] ) : array();

		if ( ! $altlar ) {
			printf( '<li><a href="%s" class="%s %s">%s</a></li>', esc_url( $oge[1] ), esc_attr( $a ), $renk, esc_html( $oge[0] ) );
			continue;
		}

		if ( $mobil ) {
			// Mobil: dokununca açılan bölüm
			echo '<li><details class="group border-b border-cizgi-acik/60 last:border-0">';
			printf(
				'<summary class="flex cursor-pointer items-center justify-between py-3 font-serif text-[22px] font-medium %s">%s<span class="akordiyon-ok transition-transform">%s</span></summary>',
				$renk,
				esc_html( $oge[0] ),
				karma_icon( 'ok-asagi', 20 )
			);
			echo '<ul class="flex flex-col pb-3 pl-1">';
			printf( '<li><a href="%s" class="block py-2 font-semibold">%s</a></li>', esc_url( $oge[1] ), esc_html( sprintf( __( 'Tüm %s ürünleri', 'karma' ), $oge[0] ) ) );
			foreach ( $altlar as $t ) {
				printf( '<li><a href="%s" class="block py-2 text-ikincil hover:text-espresso">%s</a></li>', esc_url( get_term_link( $t ) ), esc_html( $t->name ) );
			}
			echo '</ul></details></li>';
			continue;
		}

		// Masaüstü: üzerine gelince açılan liste
		echo '<li class="group relative">';
		printf(
			'<a href="%s" class="%s %s inline-flex items-center gap-1" aria-haspopup="true">%s<span class="transition-transform group-hover:rotate-180 group-focus-within:rotate-180">%s</span></a>',
			esc_url( $oge[1] ), esc_attr( $a ), $renk, esc_html( $oge[0] ), karma_icon( 'ok-asagi', 14 )
		);
		echo '<div class="invisible absolute left-1/2 top-full z-50 -translate-x-1/2 pt-[26px] opacity-0 transition-all duration-150 group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100">';
		echo '<ul class="min-w-[220px] rounded-2xl border border-cizgi-acik bg-krem p-3 shadow-[0_12px_32px_-12px_rgba(59,42,32,.25)]">';
		foreach ( $altlar as $t ) {
			printf( '<li><a href="%s" class="block rounded-lg px-3 py-2 text-normal hover:bg-acik-bej">%s</a></li>', esc_url( get_term_link( $t ) ), esc_html( $t->name ) );
		}
		printf(
			'<li class="mt-2 border-t border-cizgi-acik pt-2"><a href="%s" class="block rounded-lg px-3 py-2 text-kucuk font-semibold underline-offset-4 hover:underline">%s</a></li>',
			esc_url( $oge[1] ),
			esc_html__( 'Tümünü gör', 'karma' )
		);
		echo '</ul></div></li>';
	}
	echo '</ul>';
}

/** wp_nav_menu bağlantılarına sınıf ekleyebilmek için. */
add_filter( 'nav_menu_link_attributes', function ( $atts, $item, $args ) {
	if ( ! empty( $args->link_class ) ) {
		$atts['class'] = trim( ( $atts['class'] ?? '' ) . ' ' . $args->link_class );
	}
	return $atts;
}, 10, 3 );

/** Alt bilgi sütunu: menü atanmışsa onu, yoksa varsayılan bağlantıları yazar. */
function karma_alt_menu( $konum, $varsayilan ) {
	$a = 'text-kucuk text-bej hover:text-krem';
	if ( has_nav_menu( $konum ) ) {
		wp_nav_menu( array(
			'theme_location' => $konum,
			'container'      => false,
			'menu_class'     => 'flex flex-col gap-2',
			'depth'          => 1,
			'link_class'     => $a,
		) );
		return;
	}
	echo '<ul class="flex flex-col gap-2">';
	foreach ( $varsayilan as $etiket => $url ) {
		printf( '<li><a href="%s" class="%s">%s</a></li>', esc_url( $url ), esc_attr( $a ), esc_html( $etiket ) );
	}
	echo '</ul>';
}

/** Özelleştiriciden seçilen görseli yazdır; yoksa tasarımdaki ton ile boş alan bırakır. */
function karma_gorsel( $ayar, $sinif, $alt = '', $boyut = 'large', $yukle = 'lazy' ) {
	$id = absint( karma_ayar( $ayar ) );
	if ( $id ) {
		echo wp_get_attachment_image( $id, $boyut, false, array(
			'class'   => $sinif,
			'alt'     => $alt,
			'loading' => $yukle,
			'decoding'=> 'async',
		) );
		return;
	}

	// Özelleştiriciden görsel seçilmemişse temanın kendi görseli (assets/img).
	$tema_gorselleri = array(
		'hero_gorsel'      => array( 'hero', 940, 1200 ),
		'kampanya_gorsel'  => array( 'kampanya', 331, 370 ),
		'kat_kadin_gorsel' => array( 'kadin', 768, 720 ),
		'kat_erkek_gorsel' => array( 'erkek', 466, 437 ),
		'kat_yeni_gorsel'  => array( 'yeni-gelenler', 768, 720 ),
	);
	if ( isset( $tema_gorselleri[ $ayar ] ) && file_exists( KARMA_DIR . '/assets/img/' . $tema_gorselleri[ $ayar ][0] . '.jpg' ) ) {
		list( $dosya, $g, $y ) = $tema_gorselleri[ $ayar ];
		$url = KARMA_URI . '/assets/img/' . $dosya;
		printf(
			'<picture class="contents"><source srcset="%1$s.webp" type="image/webp"><img src="%1$s.jpg" width="%2$d" height="%3$d" class="%4$s" alt="%5$s" loading="%6$s" decoding="async"%7$s></picture>',
			esc_url( $url ),
			$g,
			$y,
			esc_attr( $sinif ),
			esc_attr( $alt ),
			esc_attr( $yukle ),
			'eager' === $yukle ? ' fetchpriority="high"' : ''
		);
		return;
	}

	printf( '<div class="%s bg-gorsel" role="img" aria-label="%s"></div>', esc_attr( $sinif ), esc_attr( $alt ) );
}

/** Sayfa bağlantısını slug ile bul (yoksa #). */
function karma_sayfa_linki( $slug ) {
	$sayfa = get_page_by_path( $slug );
	return $sayfa ? get_permalink( $sayfa ) : '#';
}

/** 1500 → "1.500" (Türkçe sayı biçimi). */
function karma_tl( $sayi ) {
	return number_format( (float) $sayi, 0, ',', '.' );
}
