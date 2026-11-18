<?php
/**
 * Sayfalar: sepet, ödeme, hesabım, yasal metinler, iletişim…
 */
defined( 'ABSPATH' ) || exit;
get_header();

$wc_sayfasi = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );
?>
<div class="kapsayici pb-16 pt-8 lg:pb-20 lg:pt-12">
	<?php while ( have_posts() ) : the_post(); ?>
		<h1 class="mb-8 font-serif text-[36px] font-medium leading-[1.1] lg:text-h1-urun"><?php the_title(); ?></h1>
		<div class="<?php echo $wc_sayfasi ? '' : 'icerik max-w-[760px]'; ?>">
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
</div>
<?php
get_footer();
