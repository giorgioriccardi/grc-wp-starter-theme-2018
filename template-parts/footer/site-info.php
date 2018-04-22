<?php
/**
 * Displays footer site info
 *
 * @package WordPress
 * @subpackage GRC_2018
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-info">
	<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'grc2018' ) ); ?>"><?php
		/* translators: %s: CMS name, i.e. WordPress. */
		printf( esc_html__( 'Proudly powered by %s', 'grc2018' ), 'WordPress' );
	?></a>
	<span class="sep"> | </span>
	<?php
		/* translators: 1: Theme name, 2: Theme author. */
		printf( esc_html__( 'Theme: %1$s by %2$s.', 'grc2018' ), 'grc2018', '<a href="https://giorgioriccardi.com/">GRC</a>' );
	?>
</div><!-- .site-info -->
