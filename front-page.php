<?php
/**
 * Ana sayfa (Figma: "Ana Sayfa — Masaüstü").
 * Ayarlar → Okuma → "Ana sayfanız şunu görüntülesin: Statik bir sayfa" seçilmese de bu şablon kullanılır.
 */
defined( 'ABSPATH' ) || exit;
get_header();

$wc = class_exists( 'WooCommerce' );
?>

<!-- Hero -->
<section class="kapsayici grid items-center gap-10 py-10 md:py-14 lg:grid-cols-[1fr_470px] lg:gap-12 lg:py-16">
	<div class="flex flex-col items-center gap-5 text-center">
		<p class="ust-etiket text-karamel"><?php echo esc_html( karma_ayar( 'hero_ust' ) ); ?></p>
		<h1 class="max-w-[520px] font-serif text-[44px] font-medium leading-[1.05] sm:text-[54px] lg:text-display"><?php echo esc_html( karma_ayar( 'hero_baslik' ) ); ?></h1>
		<p class="max-w-[440px] text-normal text-ikincil sm:text-buyuk"><?php echo esc_html( karma_ayar( 'hero_metin' ) ); ?></p>
		<div class="flex flex-wrap justify-center gap-3 pt-2">
			<a href="<?php echo esc_url( karma_kategori_linki( 'kadin' ) ); ?>" class="btn btn-dolu"><?php esc_html_e( 'Kadın', 'karma' ); ?></a>
			<a href="<?php echo esc_url( karma_kategori_linki( 'erkek' ) ); ?>" class="btn btn-cizgili"><?php esc_html_e( 'Erkek', 'karma' ); ?></a>
		</div>
	</div>

	<div class="relative mx-auto aspect-[470/600] w-full max-w-[470px] overflow-hidden rounded-2xl">
		<?php karma_gorsel( 'hero_gorsel', 'absolute inset-0 size-full object-cover', __( 'Yeni sezon Karma koleksiyonu', 'karma' ), 'large', 'eager' ); ?>
		<div class="pointer-events-none absolute inset-4 rounded-lg border border-[rgba(61,41,26,0.45)]"></div>
		<div class="pointer-events-none relative flex flex-col items-center gap-1.5 pt-[9%]">
			<span class="font-serif text-[clamp(48px,14vw,76px)] font-semibold leading-none tracking-[0.28em] text-[rgba(61,41,26,0.82)]" aria-hidden="true">KARMA</span>
			<span class="whitespace-pre text-[12px] font-medium tracking-[0.4em] text-[rgba(61,41,26,0.7)]" aria-hidden="true">—  EST. 2026  —</span>
		</div>
	</div>
</section>

<?php if ( karma_ayar( 'kampanya_goster' ) ) : ?>
<!-- İndirim kampanyası -->
<section class="kapsayici pb-14 lg:pb-16">
	<div class="grid overflow-hidden rounded-[20px] bg-kampanya lg:grid-cols-[1fr_520px]">
		<div class="order-2 flex flex-col items-center justify-center gap-[18px] px-6 py-12 text-center lg:order-1 lg:px-12 lg:py-[72px]">
			<p class="ust-etiket text-ikincil"><?php esc_html_e( 'Kadın ve erkek için, her an için', 'karma' ); ?></p>
			<h2 class="font-serif text-[44px] font-medium uppercase leading-none tracking-[0.03em] sm:text-[60px] lg:text-dev">
				<?php esc_html_e( 'Sezon sonu', 'karma' ); ?><br><?php esc_html_e( 'İndirimi', 'karma' ); ?>
			</h2>
			<div class="flex w-[260px] max-w-full items-center gap-[6px] text-espresso" aria-hidden="true">
				<span class="h-px flex-1 bg-current opacity-60"></span>
				<svg width="15" height="11" viewBox="0 0 15 11"><path d="M7.5 11S0 6.6 0 2.9A2.9 2.9 0 0 1 5.2 1.2L7.5 3.3l2.3-2.1A2.9 2.9 0 0 1 15 2.9C15 6.6 7.5 11 7.5 11Z" fill="currentColor"/></svg>
				<span class="h-px flex-1 bg-current opacity-60"></span>
			</div>
			<p class="text-normal sm:text-buyuk">
				<?php
				/* translators: %s: indirim oranı */
				printf( esc_html__( "Seçili ürünlerde %%%s'e varan indirim", 'karma' ), esc_html( karma_ayar( 'indirim_orani' ) ) );
				?>
			</p>
			<a href="<?php echo esc_url( karma_ayar( 'kampanya_link' ) ?: karma_kategori_linki( 'indirim' ) ); ?>" class="btn btn-dolu"><?php esc_html_e( 'Fırsatları Keşfet', 'karma' ); ?></a>
		</div>
		<div class="relative order-1 aspect-[520/400] lg:order-2 lg:aspect-auto">
			<?php karma_gorsel( 'kampanya_gorsel', 'absolute inset-0 size-full object-cover object-top', __( 'Sezon sonu indirimi', 'karma' ) ); ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- Kategoriler -->
<section class="kapsayici pb-14 pt-2 lg:pb-16 lg:pt-8">
	<h2 class="baslik-h2 mb-6"><?php esc_html_e( 'Alışverişe başla', 'karma' ); ?></h2>
	<div class="-mx-4 flex snap-x snap-mandatory scroll-px-4 gap-4 overflow-x-auto px-4 pb-2 [scrollbar-width:none] sm:mx-0 sm:grid sm:grid-cols-3 sm:gap-6 sm:overflow-visible sm:px-0 sm:pb-0">
		<?php
		$kategoriler = array(
			array( 'Kadın', karma_kategori_linki( 'kadin' ), 'kat_kadin_gorsel' ),
			array( 'Erkek', karma_kategori_linki( 'erkek' ), 'kat_erkek_gorsel' ),
			array( 'Yeni Gelenler', karma_magaza_linki( array( 'orderby' => 'date' ) ), 'kat_yeni_gorsel' ),
		);
		foreach ( $kategoriler as $k ) :
			?>
			<a href="<?php echo esc_url( $k[1] ); ?>" class="group flex w-[78%] shrink-0 snap-start flex-col gap-[14px] sm:w-auto">
				<div class="relative aspect-[384/360] overflow-hidden rounded-[14px]">
					<?php karma_gorsel( $k[2], 'absolute inset-0 size-full object-cover object-top transition-transform duration-500 group-hover:scale-[1.03]', $k[0] ); ?>
				</div>
				<span class="flex items-center gap-2 text-[18px] font-semibold leading-[1.6] sm:text-[20px]">
					<?php echo esc_html( $k[0] ); ?>
					<span class="transition-transform group-hover:translate-x-1"><?php echo karma_icon( 'ok-sag', 18 ); ?></span>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
</section>

<?php
if ( $wc ) :
	$yeni = wc_get_products( array(
		'status'     => 'publish',
		'limit'      => 4,
		'orderby'    => 'date',
		'order'      => 'DESC',
		'visibility' => 'catalog',
	) );
	?>
<!-- Yeni gelenler -->
<section class="bg-acik-bej py-12 lg:py-16">
	<div class="kapsayici">
		<div class="mb-7 flex items-baseline justify-between gap-4">
			<h2 class="baslik-h2"><?php esc_html_e( 'Yeni gelenler', 'karma' ); ?></h2>
			<a href="<?php echo esc_url( karma_magaza_linki( array( 'orderby' => 'date' ) ) ); ?>" class="shrink-0 text-kucuk font-semibold underline underline-offset-4 hover:text-karamel sm:text-normal"><?php esc_html_e( 'Tümünü gör', 'karma' ); ?></a>
		</div>
		<?php if ( $yeni ) : ?>
			<div class="grid grid-cols-2 gap-x-4 gap-y-8 md:grid-cols-3 lg:grid-cols-4 lg:gap-8">
				<?php
				foreach ( $yeni as $i => $urun ) {
					echo 3 === $i ? '<div class="md:hidden lg:block">' : '<div>';
					get_template_part( 'template-parts/urun-karti', null, array( 'urun' => $urun ) );
					echo '</div>';
				}
				?>
			</div>
		<?php else : ?>
			<p class="text-ikincil"><?php esc_html_e( 'Henüz ürün eklenmedi. WooCommerce → Ürünler bölümünden ilk ürününü ekleyebilirsin.', 'karma' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<!-- Avantajlar -->
<section class="kapsayici grid gap-6 py-10 sm:grid-cols-3 sm:gap-8 lg:py-14">
	<?php
	$avantajlar = array(
		array( 'kargo', __( 'Ücretsiz kargo', 'karma' ), sprintf( __( '%s TL ve üzeri siparişlerde', 'karma' ), karma_tl( karma_ayar( 'kargo_limiti' ) ) ) ),
		array( 'iade', __( 'Kolay iade', 'karma' ), sprintf( __( '%s gün içinde ücretsiz', 'karma' ), karma_ayar( 'iade_gun' ) ) ),
		array( 'kilit', __( 'Güvenli ödeme', 'karma' ), __( 'Kart bilgilerin korunur', 'karma' ) ),
	);
	foreach ( $avantajlar as $a ) :
		?>
		<div class="flex items-start gap-[14px]">
			<span class="shrink-0 text-karamel"><?php echo karma_icon( $a[0], 28 ); ?></span>
			<div class="flex flex-col gap-[2px]">
				<p class="font-semibold"><?php echo esc_html( $a[1] ); ?></p>
				<p class="text-kucuk text-ikincil"><?php echo esc_html( $a[2] ); ?></p>
			</div>
		</div>
	<?php endforeach; ?>
</section>

<!-- Bülten -->
<section class="kapsayici pb-14 lg:pb-16">
	<div class="flex flex-col gap-6 rounded-[20px] bg-bej px-6 py-10 lg:flex-row lg:items-center lg:justify-between lg:px-10 lg:py-12">
		<div class="flex flex-col gap-2">
			<h2 class="max-w-[480px] font-serif text-[30px] font-medium leading-[1.2] lg:text-h3"><?php esc_html_e( 'Yeniliklerden ilk sen haberdar ol', 'karma' ); ?></h2>
			<p class="text-ikincil"><?php esc_html_e( 'Yeni koleksiyonlar ve kampanyalar e-posta kutunda.', 'karma' ); ?></p>
		</div>
		<form class="flex w-full flex-col gap-[10px] sm:flex-row sm:items-end lg:w-auto" data-bulten action="#" method="post">
			<div class="flex flex-1 flex-col gap-[6px] lg:w-[300px] lg:flex-none">
				<label for="bulten-eposta" class="text-kucuk"><?php esc_html_e( 'E-posta adresin', 'karma' ); ?></label>
				<input id="bulten-eposta" type="email" name="eposta" required autocomplete="email" class="girdi" placeholder="ornek@mail.com">
			</div>
			<button type="submit" class="btn btn-koyu shrink-0"><?php esc_html_e( 'Abone ol', 'karma' ); ?></button>
		</form>
	</div>
</section>

<?php
get_footer();
