<?php
/**
 * İlk kurulum: Kadın / Erkek / İndirim kategorileri ve alt kategorileri yoksa oluşturur.
 * Bir kez çalışır. Var olan kategorilere dokunmaz; sonradan panelden silinen/eklenenler korunur.
 * Yeniden çalıştırmak için: karma_kategori_kurulumu seçeneğini silmek yeterli.
 */

defined( 'ABSPATH' ) || exit;

function karma_varsayilan_kategoriler() {
	return array(
		'kadin'   => array( 'Kadın', array( 'Elbise', 'Tişört', 'Gömlek', 'Pantolon', 'Jean', 'Etek', 'Sweatshirt', 'Ceket' ) ),
		'erkek'   => array( 'Erkek', array( 'Tişört', 'Gömlek', 'Pantolon', 'Jean', 'Sweatshirt', 'Ceket' ) ),
		'indirim' => array( 'İndirim', array() ),
	);
}

/** Kategoriyi bul: önce kısa ada, sonra aynı ebeveyn altındaki ada göre. */
function karma_kategori_bul( $slug, $ad, $ebeveyn = 0 ) {
	$t = get_term_by( 'slug', $slug, 'product_cat' );
	if ( $t ) {
		return $t;
	}
	foreach ( get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $ebeveyn, 'hide_empty' => false ) ) as $aday ) {
		if ( mb_strtolower( $aday->name ) === mb_strtolower( $ad ) ) {
			return $aday;
		}
	}
	return null;
}

function karma_kategorileri_kur() {
	$sira = 0;
	foreach ( karma_varsayilan_kategoriler() as $slug => $veri ) {
		list( $ad, $altlar ) = $veri;

		$ust = karma_kategori_bul( $slug, $ad );
		if ( ! $ust ) {
			$sonuc = wp_insert_term( $ad, 'product_cat', array( 'slug' => $slug ) );
			if ( is_wp_error( $sonuc ) ) {
				continue;
			}
			$ust_id = $sonuc['term_id'];
			update_term_meta( $ust_id, 'order', $sira );
		} else {
			$ust_id = $ust->term_id;
		}
		$sira++;

		$alt_sira = 0;
		foreach ( $altlar as $alt_ad ) {
			$alt_slug = $slug . '-' . sanitize_title( $alt_ad );
			if ( ! karma_kategori_bul( $alt_slug, $alt_ad, $ust_id ) ) {
				$sonuc = wp_insert_term( $alt_ad, 'product_cat', array( 'slug' => $alt_slug, 'parent' => $ust_id ) );
				if ( ! is_wp_error( $sonuc ) ) {
					update_term_meta( $sonuc['term_id'], 'order', $alt_sira ); // menüdeki sıra
				}
			}
			$alt_sira++;
		}
	}
}

add_action( 'init', function () {
	if ( ! taxonomy_exists( 'product_cat' ) || get_option( 'karma_kategori_kurulumu' ) ) {
		return;
	}
	karma_kategorileri_kur();
	update_option( 'karma_kategori_kurulumu', KARMA_VERSION, false );
}, 20 );
