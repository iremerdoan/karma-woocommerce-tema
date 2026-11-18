<?php
/**
 * Kategori sayfasında alt kategori seçenekleri:
 * Kadın → [Tümü] [Elbise] [Tişört] [Pantolon] …
 * Alt kategorideyken de (ör. Kadın / Tişört) aynı sıra gösterilir, seçili olan koyu olur.
 */
defined( 'ABSPATH' ) || exit;

if ( ! is_product_category() ) {
	return;
}

$simdiki = get_queried_object();

// Üstteki ana kategoriyi bul (Kadın / Erkek)
$ana = $simdiki;
while ( $ana && $ana->parent ) {
	$ana = get_term( $ana->parent, 'product_cat' );
}

$altlar = karma_alt_kategoriler( $ana );
if ( ! $altlar ) {
	return;
}

$sinif = 'inline-flex h-10 shrink-0 items-center rounded-full border-[1.5px] px-5 text-kucuk font-medium transition-colors';
$acik  = 'border-cizgi-orta bg-beyaz text-espresso hover:border-espresso';
$koyu  = 'border-espresso bg-espresso text-krem';
?>
<nav class="-mx-4 mb-8 overflow-x-auto px-4 [scrollbar-width:none] sm:mx-0 sm:px-0" aria-label="<?php echo esc_attr( sprintf( __( '%s kategorileri', 'karma' ), $ana->name ) ); ?>">
	<ul class="flex gap-2 sm:flex-wrap">
		<li>
			<a href="<?php echo esc_url( get_term_link( $ana ) ); ?>" class="<?php echo esc_attr( $sinif . ' ' . ( $simdiki->term_id === $ana->term_id ? $koyu : $acik ) ); ?>" <?php echo $simdiki->term_id === $ana->term_id ? 'aria-current="page"' : ''; ?>>
				<?php esc_html_e( 'Tümü', 'karma' ); ?>
			</a>
		</li>
		<?php foreach ( $altlar as $t ) : ?>
			<?php $secili = $simdiki->term_id === $t->term_id || term_is_ancestor_of( $t, $simdiki, 'product_cat' ); ?>
			<li>
				<a href="<?php echo esc_url( get_term_link( $t ) ); ?>" class="<?php echo esc_attr( $sinif . ' ' . ( $secili ? $koyu : $acik ) ); ?>" <?php echo $secili ? 'aria-current="page"' : ''; ?>>
					<?php echo esc_html( $t->name ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
