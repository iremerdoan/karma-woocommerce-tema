<?php
/**
 * Tema ikonları (satır içi SVG). Kullanım: echo karma_icon( 'sepet' );
 */

defined( 'ABSPATH' ) || exit;

function karma_icon( $ad, $boyut = 22, $sinif = '' ) {
	$yollar = array(
		'ara'     => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
		'hesap'   => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>',
		'sepet'   => '<path d="M6 7h12l-1 13H7L6 7Z"/><path d="M9 7V6a3 3 0 0 1 6 0v1"/>',
		'menu'    => '<path d="M4 7h16M4 12h16M4 17h16"/>',
		'kapat'   => '<path d="M6 6l12 12M18 6 6 18"/>',
		'ok-asagi'=> '<path d="m6 9 6 6 6-6"/>',
		'ok-sag'  => '<path d="M5 12h14M13 6l6 6-6 6"/>',
		'kargo'   => '<path d="M3 6h11v10H3z"/><path d="M14 9h4l3 3v4h-7"/><circle cx="7" cy="17.5" r="1.8"/><circle cx="17" cy="17.5" r="1.8"/>',
		'iade'    => '<path d="M4 12a8 8 0 1 0 2.4-5.7"/><path d="M4 4v4h4"/>',
		'kilit'   => '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/>',
		'onay'    => '<path d="m5 12 4.5 4.5L19 7"/>',
		'kalp'    => '<path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10Z"/>',
	);

	if ( ! isset( $yollar[ $ad ] ) ) {
		return '';
	}

	return sprintf(
		'<svg xmlns="http://www.w3.org/2000/svg" width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="%2$s" aria-hidden="true" focusable="false">%3$s</svg>',
		(int) $boyut,
		esc_attr( $sinif ),
		$yollar[ $ad ]
	);
}

/** Logo yanındaki dört köşeli ışıltı. */
function karma_isilti( $boyut, $stil = '' ) {
	return sprintf(
		'<svg width="%1$s" height="%1$s" viewBox="0 0 16 16" aria-hidden="true" class="absolute" style="%2$s"><path d="M8 0c.5 4.2 2.8 6.6 8 8-5.2 1.4-7.5 3.8-8 8-.5-4.2-2.8-6.6-8-8 5.2-1.4 7.5-3.8 8-8Z" fill="#d9b26e"/></svg>',
		esc_attr( $boyut ),
		esc_attr( $stil )
	);
}
