<?php
/**
 * GRC 2018 Theme Customizer
 *
 * @package GRC_2018
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function grc2018_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'grc2018_customize_partial_blogname',
			)
		);
			$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
				'selector'        => '.site-description',
				'render_callback' => 'grc2018_customize_partial_blogdescription',
			)
		);

		// GRC
		/**
		 * Add a new Theme options
		 */
		$wp_customize->add_section(
			'theme_options', array(
				'title'    		=> __( 'Theme Options', 'grc2018' ),
				'priority' 		=> 130, // Before Additional CSS.
				'capability'	=> 'edit_theme_options',
				'description'	=> __( 'Toggle on/off Recent Posts Swiper Slider' ),
			)
		);

		// add settings and controls for Swiper Slider
		$wp_customize->add_setting(
			'swiper_slider', array(
				'default'           => '',
				'transport'         => 'postMessage',
				'type'							=> 'theme_mod',
				'sanitize_callback' => 'grc2018_sanitize_swiperslider',
			)
		);

		$wp_customize->add_control(
			'swiper_slider', array(
				'type'     				=> 'radio',
				'description'     => __( 'Create an automatic slider on the homepage with the latest 3 posts' ),
				'label'    				=> __( 'Swiper Slider', 'grc2018' ),
				'choices'  				=> array(
				''  	 								=> __( 'On (default)', 'grc2018' ),
				'none'    						=> __( 'Off', 'grc2018' ),
				),
				'section'  				=> 'theme_options',
				'settings' 				=> 'swiper_slider', // Match setting ID from above
				'priority' 				=> 5,
			)
		); // end of Swiper Slider Options
	}
}
add_action( 'customize_register', 'grc2018_customize_register' );

/**
 * Sanitize the SwiperSlider.
 *
 * @param string $input Swiper Slider.
 */
function grc2018_sanitize_swiperslider( $input ) {
	$valid = array(
		'' 				=> __( 'On', 'grc2018' ),
		'none' 		=> __( 'Off', 'grc2018' ),
	);
	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	}
	return '';
}

/**
 * Display/Hide Swiper Slider styles
 *
 */
function swiper_slider_toggle_css() {
	?>
	<style type='text/css'>
		.swiper-container {
			display:<?php echo get_theme_mod('swiper_slider') ?> ;
		}
	</style>
	<?php
}
add_action( 'wp_head' , 'swiper_slider_toggle_css' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function grc2018_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function grc2018_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function grc2018_customize_preview_js() {
	wp_enqueue_script( 'grc2018-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'grc2018_customize_preview_js' );
