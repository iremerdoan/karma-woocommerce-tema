<?php
/**
 * Ürün sayfası (Figma: "Ürün Sayfası — Masaüstü").
 * WooCommerce şablonunun Karma sürümü.
 *
 * @version 3.6.0
 */
defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput
	return;
}

// Varsayılan özet parçalarını kaldır; aşağıda kendi düzenimizle yazıyoruz.
// (Kancanın kendisi çalışmaya devam eder: Google için ürün verisi ve eklentiler bozulmaz.)
foreach ( array(
	'woocommerce_template_single_title'       => 5,
	'woocommerce_template_single_rating'      => 10,
	'woocommerce_template_single_price'       => 10,
	'woocommerce_template_single_excerpt'     => 20,
	'woocommerce_template_single_add_to_cart' => 30,
	'woocommerce_template_single_meta'        => 40,
	'woocommerce_template_single_sharing'     => 50,
) as $fn => $oncelik ) {
	remove_action( 'woocommerce_single_product_summary', $fn, $oncelik );
}

$gorseller = array_filter( array_merge( array( $product->get_image_id() ), $product->get_gallery_image_ids() ) );
$aciklama  = $product->get_description() ?: $product->get_short_description();
$kumas     = $product->get_meta( '_karma_kumas_bakim' );
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'kapsayici pb-16 pt-6 lg:pb-20', $product ); ?>>
	<div class="grid gap-8 lg:grid-cols-[minmax(0,660px)_minmax(0,484px)] lg:justify-between lg:gap-14">

		<!-- Galeri -->
		<div class="flex flex-col gap-3" data-galeri>
			<div class="relative aspect-[660/680] overflow-hidden rounded-2xl bg-gorsel">
				<?php if ( $gorseller ) : ?>
					<?php
					echo wp_get_attachment_image( $gorseller[0], 'woocommerce_single', false, array(
						'class'          => 'size-full object-cover',
						'data-ana-gorsel'=> '',
						'loading'        => 'eager',
						'fetchpriority'  => 'high',
						'sizes'          => '(min-width: 1024px) 660px, 100vw',
					) );
					?>
				<?php else : ?>
					<div class="flex size-full items-center justify-center text-kucuk text-ikincil"><?php esc_html_e( 'Ürün fotoğrafı eklenmedi', 'karma' ); ?></div>
				<?php endif; ?>
				<?php if ( $product->is_on_sale() ) : ?>
					<span class="absolute left-4 top-4 rounded-full bg-karamel px-3 py-1 text-[13px] font-semibold text-white"><?php esc_html_e( 'İndirim', 'karma' ); ?></span>
				<?php endif; ?>
			</div>

			<?php if ( count( $gorseller ) > 1 ) : ?>
				<div class="-mx-4 flex gap-3 overflow-x-auto px-4 [scrollbar-width:none] sm:mx-0 sm:grid sm:grid-cols-4 sm:px-0">
					<?php foreach ( $gorseller as $i => $id ) : ?>
						<?php
						$buyuk = wp_get_attachment_image_src( $id, 'woocommerce_single' );
						?>
						<button type="button"
							class="aspect-[155/130] w-[28%] shrink-0 overflow-hidden rounded-[10px] border-2 bg-bej sm:w-auto <?php echo 0 === $i ? 'border-espresso' : 'border-transparent'; ?>"
							data-kucuk-gorsel
							data-src="<?php echo esc_url( $buyuk[0] ?? '' ); ?>"
							data-srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $id, 'woocommerce_single' ) ?: '' ); ?>"
							aria-label="<?php echo esc_attr( sprintf( __( 'Görsel %d', 'karma' ), $i + 1 ) ); ?>"
							aria-pressed="<?php echo 0 === $i ? 'true' : 'false'; ?>">
							<?php echo wp_get_attachment_image( $id, 'woocommerce_thumbnail', false, array( 'class' => 'size-full object-cover', 'alt' => '', 'loading' => 'lazy' ) ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<!-- Ürün bilgisi -->
		<div class="flex flex-col gap-7 lg:sticky lg:top-[110px] lg:self-start">
			<div class="flex flex-col gap-[6px]">
				<h1 class="product_title font-serif text-[36px] font-medium leading-[1.1] lg:text-h1-urun"><?php the_title(); ?></h1>
				<p class="price text-fiyat font-semibold"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
			</div>

			<div class="karma-sepet-formu">
				<?php woocommerce_template_single_add_to_cart(); ?>
			</div>

			<ul class="flex flex-col gap-[6px] text-kucuk text-ikincil">
				<li class="flex items-center gap-2"><?php echo karma_icon( 'onay', 16 ); ?> <?php echo esc_html( sprintf( __( '%s TL üzeri ücretsiz kargo', 'karma' ), karma_tl( karma_ayar( 'kargo_limiti' ) ) ) ); ?></li>
				<li class="flex items-center gap-2"><?php echo karma_icon( 'onay', 16 ); ?> <?php echo esc_html( sprintf( __( '%s gün içinde kolay iade', 'karma' ), karma_ayar( 'iade_gun' ) ) ); ?></li>
			</ul>

			<div class="border-t border-cizgi-acik">
				<?php
				$detaylar = array(
					array( __( 'Ürün açıklaması', 'karma' ), $aciklama ? wpautop( wp_kses_post( $aciklama ) ) : '', true ),
					array( __( 'Kumaş ve bakım', 'karma' ), $kumas ? wpautop( esc_html( $kumas ) ) : '', false ),
					array( __( 'Kargo ve iade', 'karma' ), wpautop( esc_html( karma_ayar( 'kargo_iade_metni' ) ) ), false ),
				);
				foreach ( $detaylar as $d ) :
					if ( ! $d[1] ) {
						continue;
					}
					?>
					<details class="group border-b border-cizgi-acik" <?php echo $d[2] ? 'open' : ''; ?>>
						<summary class="flex cursor-pointer items-center justify-between py-[18px] font-semibold">
							<?php echo esc_html( $d[0] ); ?>
							<span class="akordiyon-ok transition-transform"><?php echo karma_icon( 'ok-asagi', 20 ); ?></span>
						</summary>
						<div class="icerik -mt-2 pb-[18px] text-kucuk text-ikincil [&_p:last-child]:mb-0"><?php echo $d[1]; // phpcs:ignore WordPress.Security.EscapeOutput -- yukarıda temizlendi ?></div>
					</details>
				<?php endforeach; ?>
			</div>

			<?php do_action( 'woocommerce_single_product_summary' ); ?>
		</div>
	</div>

	<?php if ( function_exists( 'woocommerce_output_related_products' ) ) : ?>
		<div class="karma-benzer mt-16 lg:mt-24">
			<?php woocommerce_output_related_products(); ?>
		</div>
	<?php endif; ?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
