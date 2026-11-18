<?php
/**
 * Alt kısım (Figma: "Alt Bilgi").
 */
defined( 'ABSPATH' ) || exit;
$wc = class_exists( 'WooCommerce' );
?>
</main>

<footer class="bg-espresso text-bej">
	<div class="kapsayici pb-8 pt-12 lg:pt-14">
		<div class="grid grid-cols-2 gap-x-8 gap-y-10 lg:grid-cols-4">
			<div class="col-span-2 flex flex-col gap-2 lg:col-span-1">
				<?php get_template_part( 'template-parts/logo', null, array( 'boyut' => 'alt' ) ); ?>
				<p class="text-kucuk"><?php esc_html_e( 'Kadın ve erkek giyim.', 'karma' ); ?></p>
			</div>

			<div>
				<h2 class="mb-2 text-kucuk font-semibold text-krem"><?php esc_html_e( 'Alışveriş', 'karma' ); ?></h2>
				<?php
				karma_alt_menu( 'alt-alisveris', array(
					'Kadın'         => karma_kategori_linki( 'kadin' ),
					'Erkek'         => karma_kategori_linki( 'erkek' ),
					'Yeni Gelenler' => karma_magaza_linki( array( 'orderby' => 'date' ) ),
				) );
				?>
			</div>

			<div>
				<h2 class="mb-2 text-kucuk font-semibold text-krem"><?php esc_html_e( 'Yardım', 'karma' ); ?></h2>
				<?php
				karma_alt_menu( 'alt-yardim', array(
					'Beden Rehberi' => karma_sayfa_linki( 'beden-rehberi' ),
					'Kargo ve İade' => karma_sayfa_linki( 'kargo-ve-iade' ),
					'İletişim'      => karma_sayfa_linki( 'iletisim' ),
				) );
				?>
			</div>

			<div>
				<h2 class="mb-2 text-kucuk font-semibold text-krem"><?php esc_html_e( 'Bizi takip et', 'karma' ); ?></h2>
				<ul class="flex flex-col gap-2">
					<li><a href="<?php echo esc_url( karma_ayar( 'instagram' ) ?: '#' ); ?>" class="text-kucuk hover:text-krem" target="_blank" rel="noopener">Instagram</a></li>
					<li><a href="<?php echo esc_url( karma_ayar( 'tiktok' ) ?: '#' ); ?>" class="text-kucuk hover:text-krem" target="_blank" rel="noopener">TikTok</a></li>
				</ul>
			</div>
		</div>

		<div class="mt-10 flex flex-col gap-3 border-t border-cizgi-koyu pt-5 text-kucuk sm:flex-row sm:items-center sm:justify-between">
			<p>© <?php echo esc_html( wp_date( 'Y' ) ); ?> Karma</p>
			<?php if ( $wc && wc_terms_and_conditions_page_id() ) : ?>
				<a href="<?php echo esc_url( get_permalink( wc_terms_and_conditions_page_id() ) ); ?>" class="hover:text-krem"><?php esc_html_e( 'Mesafeli Satış Sözleşmesi', 'karma' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
