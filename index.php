<?php
/**
 * Yedek şablon (blog, arama sonuçları vb.).
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>
<div class="kapsayici pb-16 pt-8 lg:pb-20 lg:pt-12">
	<h1 class="mb-8 font-serif text-[36px] font-medium leading-[1.1] lg:text-h1-urun">
		<?php
		if ( is_search() ) {
			printf( esc_html__( '"%s" için sonuçlar', 'karma' ), esc_html( get_search_query() ) );
		} elseif ( is_404() ) {
			esc_html_e( 'Sayfa bulunamadı', 'karma' );
		} else {
			echo esc_html( wp_get_document_title() );
		}
		?>
	</h1>

	<?php if ( have_posts() ) : ?>
		<div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="flex flex-col gap-3">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-xl"><?php the_post_thumbnail( 'medium_large', array( 'class' => 'aspect-[4/3] w-full object-cover' ) ); ?></a>
					<?php endif; ?>
					<h2 class="text-[20px] font-semibold"><a href="<?php the_permalink(); ?>" class="hover:text-karamel"><?php the_title(); ?></a></h2>
					<div class="text-kucuk text-ikincil"><?php the_excerpt(); ?></div>
				</article>
			<?php endwhile; ?>
		</div>
		<div class="mt-10"><?php the_posts_pagination(); ?></div>
	<?php else : ?>
		<p class="mb-6 text-ikincil"><?php esc_html_e( 'Aradığını bulamadık.', 'karma' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-dolu"><?php esc_html_e( 'Ana sayfaya dön', 'karma' ); ?></a>
	<?php endif; ?>
</div>
<?php
get_footer();
