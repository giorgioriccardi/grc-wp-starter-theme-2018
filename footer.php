<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GRC_2018
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

		<!-- GRC footer Social Links Menu -->
		<!-- Nicked from TwentySeventeen -->
		<div class="wrap">
			<?php
			if ( has_nav_menu( 'social' ) ) :
			?>
				<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'grc2018' ); ?>">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'social',
								'menu_class'     => 'social-links-menu',
								'depth'          => 1,
								'link_before'    => '<span class="screen-reader-text">',
								'link_after'     => '</span>' . grc2018_get_svg( array( 'icon' => 'chain' ) ),
							)
						);
					?>
				</nav><!-- .social-navigation -->
			<?php
			endif;

			get_template_part( 'template-parts/footer/site', 'info' );
			?>
		</div><!-- .wrap -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
