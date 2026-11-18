<?php
/**
 * Üst kısım: duyuru çubuğu + üst menü (Figma: "Duyuru Çubuğu", "Üst Menü").
 */
defined( 'ABSPATH' ) || exit;
$wc = class_exists( 'WooCommerce' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a href="#icerik" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-full focus:bg-espresso focus:px-4 focus:py-2 focus:text-krem"><?php esc_html_e( 'İçeriğe geç', 'karma' ); ?></a>

<div class="bg-espresso px-4 py-[10px] text-center text-[12px] leading-[1.5] text-krem sm:text-kucuk">
	<?php echo esc_html( karma_duyuru_metni() ); ?>
</div>

<header class="sticky top-0 z-40 border-b border-cizgi-acik bg-krem/95 backdrop-blur supports-[backdrop-filter]:bg-krem/85">
	<div class="kapsayici flex h-[64px] items-center justify-between gap-4 lg:h-[86px]">

		<!-- Mobil: menü butonu -->
		<button type="button" class="-ml-2 flex size-11 items-center justify-center lg:hidden" data-ac="mobil-menu" aria-controls="mobil-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Menüyü aç', 'karma' ); ?>">
			<?php echo karma_icon( 'menu' ); ?>
		</button>

		<?php get_template_part( 'template-parts/logo', null, array( 'boyut' => 'ust' ) ); ?>

		<nav class="hidden lg:block" aria-label="<?php esc_attr_e( 'Ana menü', 'karma' ); ?>">
			<?php karma_ana_menu(); ?>
		</nav>

		<div class="-mr-2 flex items-center gap-0 sm:gap-1">
			<button type="button" class="flex size-11 items-center justify-center hover:text-karamel" data-ac="arama-paneli" aria-controls="arama-paneli" aria-expanded="false" aria-label="<?php esc_attr_e( 'Ara', 'karma' ); ?>">
				<?php echo karma_icon( 'ara' ); ?>
			</button>
			<?php if ( $wc ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="hidden size-11 items-center justify-center hover:text-karamel sm:flex" aria-label="<?php esc_attr_e( 'Hesabım', 'karma' ); ?>">
					<?php echo karma_icon( 'hesap' ); ?>
				</a>
				<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="relative flex size-11 items-center justify-center hover:text-karamel" aria-label="<?php esc_attr_e( 'Sepet', 'karma' ); ?>">
					<?php echo karma_icon( 'sepet' ); ?>
					<?php karma_sepet_sayaci(); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>

	<!-- Arama paneli -->
	<div id="arama-paneli" class="hidden border-t border-cizgi-acik bg-krem">
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="kapsayici flex gap-3 py-4">
			<label for="arama-kutusu" class="sr-only"><?php esc_html_e( 'Ürün ara', 'karma' ); ?></label>
			<input id="arama-kutusu" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" class="girdi" placeholder="<?php esc_attr_e( 'Ne arıyorsun?', 'karma' ); ?>">
			<?php if ( $wc ) : ?><input type="hidden" name="post_type" value="product"><?php endif; ?>
			<button type="submit" class="btn btn-koyu shrink-0"><?php esc_html_e( 'Ara', 'karma' ); ?></button>
		</form>
	</div>
</header>

<!-- Mobil menü çekmecesi -->
<div id="mobil-menu" class="fixed inset-0 z-50 hidden lg:hidden" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Menü', 'karma' ); ?>">
	<div class="absolute inset-0 bg-espresso/40" data-kapat="mobil-menu"></div>
	<div class="absolute inset-y-0 left-0 flex w-[84%] max-w-[360px] flex-col bg-krem px-6 pb-8 pt-4 shadow-xl">
		<div class="mb-6 flex items-center justify-between">
			<?php get_template_part( 'template-parts/logo', null, array( 'boyut' => 'mobil' ) ); ?>
			<button type="button" class="-mr-2 flex size-11 items-center justify-center" data-kapat="mobil-menu" aria-label="<?php esc_attr_e( 'Menüyü kapat', 'karma' ); ?>">
				<?php echo karma_icon( 'kapat' ); ?>
			</button>
		</div>
		<nav aria-label="<?php esc_attr_e( 'Mobil menü', 'karma' ); ?>">
			<?php karma_ana_menu( true ); ?>
		</nav>
		<?php if ( $wc ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="mt-auto flex items-center gap-3 border-t border-cizgi-acik pt-5 font-medium">
				<?php echo karma_icon( 'hesap' ); ?> <?php esc_html_e( 'Hesabım', 'karma' ); ?>
			</a>
		<?php endif; ?>
	</div>
</div>

<main id="icerik">
