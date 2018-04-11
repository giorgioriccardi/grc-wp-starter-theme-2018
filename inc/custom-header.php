<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 * #1
	<?php the_header_image_tag(); ?>
 * or #2, as an alternative, this previous version:
 <?php if ( get_header_image() && is_front_page() ) : ?>
 <figure class="header-image">
	 <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		 <img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	 </a>
 </figure><!-- .header-image -->
 <?php endif; // End header image check. ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Camp_Pacific_2018
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses cp2018_header_style()
 */
function cp2018_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'cp2018_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => 'ffffff',
		'width'                  => 1920,
		'height'                 => 500,
		'flex-width'						 => true,
		// 'flex-height'            => true,
		'wp-head-callback'       => 'cp2018_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'cp2018_custom_header_setup' );

if ( ! function_exists( 'cp2018_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see cp2018_custom_header_setup().
	 */
	function cp2018_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
		?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;
