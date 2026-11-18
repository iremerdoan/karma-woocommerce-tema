<?php
/**
 * Logo (Figma: "Logo" bileşeni — altın ışıltılı KARMA yazısı).
 * $args['boyut']: 'ust' | 'mobil' | 'alt'
 */
defined( 'ABSPATH' ) || exit;

$boyut = $args['boyut'] ?? 'ust';
$yazi  = array(
	'ust'   => 'text-[30px] lg:text-[46px]',
	'mobil' => 'text-[30px]',
	'alt'   => 'text-[36.8px]',
)[ $boyut ];
// Işıltıların yerleri yazı boyutuyla orantılı (em cinsinden).
?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative inline-block w-fit pb-[0.04em] pl-[0.09em] pr-[0.3em] pt-[0.13em] <?php echo esc_attr( $yazi ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — <?php esc_attr_e( 'Ana sayfa', 'karma' ); ?>">
	<span class="logo-yazi block">KARMA</span>
	<?php
	echo karma_isilti( '0.35em', 'left:calc(100% - 0.4em);top:0' );          // büyük ışıltı
	echo karma_isilti( '0.2em', 'left:calc(100% - 0.13em);top:0.35em;opacity:.8' ); // küçük ışıltı
	echo karma_isilti( '0.17em', 'left:0;top:0.91em;opacity:.7' );            // sol alt
	?>
</a>
