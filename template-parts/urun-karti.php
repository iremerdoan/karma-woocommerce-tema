<?php
/**
 * Ürün kartı (Figma: "Ürün Kartı" — görsel, kategori, ad, fiyat).
 * $args['urun']: WC_Product
 */
defined( 'ABSPATH' ) || exit;

$urun = $args['urun'] ?? null;
if ( ! $urun instanceof WC_Product ) {
	return;
}
$link = $urun->get_permalink();
$kat  = karma_urun_ust_kategori( $urun );
?>
<article class="group flex flex-col gap-2">
	<a href="<?php echo esc_url( $link ); ?>" class="relative block aspect-[276/330] overflow-hidden rounded-xl bg-gorsel" tabindex="-1" aria-hidden="true">
		<?php
		if ( $urun->get_image_id() ) {
			echo wp_get_attachment_image( $urun->get_image_id(), 'woocommerce_thumbnail', false, array(
				'class'   => 'size-full object-cover transition-transform duration-500 group-hover:scale-[1.03]',
				'loading' => 'lazy',
				'sizes'   => '(min-width: 1024px) 276px, (min-width: 768px) 33vw, 50vw',
			) );
		}
		if ( $urun->is_on_sale() ) {
			echo '<span class="absolute left-3 top-3 rounded-full bg-karamel px-3 py-1 text-[12px] font-semibold text-white">' . esc_html__( 'İndirim', 'karma' ) . '</span>';
		}
		if ( ! $urun->is_in_stock() ) {
			echo '<span class="absolute left-3 top-3 rounded-full bg-espresso px-3 py-1 text-[12px] font-semibold text-krem">' . esc_html__( 'Tükendi', 'karma' ) . '</span>';
		}
		?>
	</a>
	<div class="flex flex-col gap-[2px] pt-[6px]">
		<?php if ( $kat ) : ?>
			<p class="text-[13px] leading-[1.5] text-ikincil sm:text-kucuk"><?php echo esc_html( $kat ); ?></p>
		<?php endif; ?>
		<h3 class="text-[15px] font-medium leading-[1.6] sm:text-normal">
			<a href="<?php echo esc_url( $link ); ?>" class="hover:text-karamel"><?php echo esc_html( $urun->get_name() ); ?></a>
		</h3>
		<p class="price text-[15px] font-semibold leading-[1.6] sm:text-normal"><?php echo wp_kses_post( $urun->get_price_html() ); ?></p>
	</div>
</article>
