<?php
/**
 * WooCommerce sayfalarının sarmalayıcısı: mağaza, kategori ve ürün sayfaları.
 * (Sepet, ödeme ve hesabım sayfaları page.php ile gösterilir.)
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<div class="kapsayici pt-5">
	<?php woocommerce_breadcrumb(); ?>
</div>

<?php if ( is_product() ) : ?>

	<?php woocommerce_content(); ?>

<?php else : ?>

	<div class="kapsayici pb-16 pt-6 lg:pb-20">
		<header class="mb-8 flex flex-col gap-2">
			<h1 class="font-serif text-[36px] font-medium leading-[1.1] lg:text-h1-urun"><?php woocommerce_page_title(); ?></h1>
			<?php do_action( 'woocommerce_archive_description' ); ?>
		</header>
		<?php get_template_part( 'template-parts/alt-kategoriler' ); ?>
		<?php woocommerce_content(); ?>
	</div>

<?php endif; ?>

<?php
get_footer();
