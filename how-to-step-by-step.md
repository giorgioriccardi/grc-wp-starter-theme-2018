# How to build a WP theme from scratch with `_s`

**This theme is just for developers and it includes just basic css implementation.**

This step-by-step guide assumes that the [Pantheon](https://pantheon.io/) (or any other given dev environment) is already up and running and that [Yeoman](https://bitbucket.org/giorgioriccardi/templates-linters.git) template is installed and ready to be compiled in the new starter theme root.

## Initial front-dev setup in WordPress Dashboard

* Create a starter theme package using [Underscores `_s`](https://underscores.me/),
	* Follow instructions on the doc page, just make sure to select all the advanced options available, especially `SASS` files.
* Give it a meaningful name, for this prototype is `GRC 2018` (slug: `grc2018`).

**~~For the sake of this prototype I will not support `WooCommerce` features right away~~**.

## Initial Theme Build

* Install Google Fonts after selecting them from the Google site;
	* copy the generated Fonts url [Dosis|Kavivanar](https://fonts.googleapis.com/css?family=Dosis:400,700|Kavivanar)
* Enqueue the above fonts into **functions.php** in the functions section `grc2018_scripts()`
	```
	wp_enqueue_style( 'grc2018-fonts', 'https://fonts.googleapis.com/css?family=Dosis:400,700|Kaviva
	nar' );
	```
* Setup the proper `_scss` file to render the new fonts in `/app/styles/variables-site/_typography.scss`
* ~~Adding control for web fonts and improve performance with preconnect for Google Fonts is skipped for this initial phase of development~~
* Create responsive typography:
	* in `/app/styles/typography/_typography.scss` we implement a media query to make the font slightly smaller below `< 767px` screen width
	* `@include font-size(0.9);`
	* `@media screen and (min-width: 768px) { @include font-size(1); }`
	* create each size for `H1` to `H6` in `/app/styles/typography/_headings.scss`
* Initial setup for responsive layout:
	* Change the order how styles get rendered by the WP theme, making sure that the content styles `@import "site/site"` are imported before the widgets styles `@import "site/secondary/widgets"`
	* Create a new sass file under `/layout/_global.scss` and add it in the `/site/_site.scss` as `@import "/layout/global"`
	* Create some initial mediaquery variables in `/variables-site/_structures.scss` such as `$query__small: 600px` and `$query__medium: 900px`
	* Assign some mediaquery rules to content in `/layout/_global.scss`

## Header styles and functionality

### Custom Header feature

* Place in **header.php** the code to to render the custom header image, the code snippet (can vary from version to version of `_s`);
is stored as a comment on top of `/inc/custom-header.php`
* Copy and paste this snippet `<?php the_header_image_tag(); ?>` into **header.php**, just above the `<header>` tag
* Note the the above snippet won't wrap the image in a `<figure>` tag and it won't link the whole header to the blog-link;
* if you want you can use an older version like this one:
	```
	<?php if ( get_header_image() ) : ?>
	<figure class="header-image">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
	<?php the_header_image_tag(); ?>
	</a>
	</figure><!-- .header-image -->
	<?php endif; // End header image check. ?>
	```

* Create a sass folder/file just for the header
	* `/site/header/_header.scss` and add it in the `/site/_site.scss` as `@import "header/header"`
	* Implement basic header's styles in `/site/header/_header.scss`

### Menus

* Register 2 menus into **functions.php**
	```
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'grc2018' ),
		'social' => esc_html__( 'Social Links Menu', 'grc2018' ),
	) );
	```

#### Primary Menu

* Make sure the main menu is ouput into **header.php**
	```
	<nav id="site-navigation" class="main-navigation">
		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'grc2018' ); ?></button>
		<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
			) );
		?>
	</nav><!-- #site-navigation -->
	```
* Clear all the `_s` default menu styles in `/navigation/_menus.scss`
* Create a sass file just for the header menu `_header-menu.scss`
	* `/site/header/_header-menu.scss` and import it in `/site/header/_header.scss` with `@import "header-menu"` at the very bottom
	* Implement basic header's styles in `/site/header/_header-menu.scss`
* Implement JavaScript logic for the menu, if different from the original provided by `_s`
* We use the TwentySeventeen `navigation.js` script and we replace all the original from `_s`
* Into **functions.php** right after the theme-navigation enqueue script we implement this code:
	```
	wp_enqueue_script( 'grc2018-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20151215', true );
	// TwentySeventeen localized script
	wp_localize_script( 'grc2018-navigation', 'grc2018ScreenReaderText',
		array(
			'aria-expand'   => __( 'Expand child menu', 'grc2018' ),
			'collapse' => __( 'Collapse child menu', 'grc2018' )
		)
	);
	```

#### Footer Social Links Menu

* Create a file **/inc/icon-functions.php**
* Enqueue the above file into **functions.php**
	```
	 /**
	  * SVG icons functions and filters.
	  * Nicked from TwentySeventeen
	  */
	 require get_parent_theme_file_path( '/inc/icon-functions.php' );
	```

* Implement PHP SVG Icons logic, I used the code from the TwentySeventeen theme
* Copy just one svg file with a full set of icons into `/assets/images/svg-icons.svg`
* Move the portion of code for the site-info into a separate template **/template-parts/footer/site-info.php**
* Add this snippet into **footer.php**
	```
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
	```
* Implement styles into `/styles/site/footer/_footer.sass`
* Enqueue the above file in `style.scss` as `@import "footer/footer"`

### Swiper Slider
[Getting Started with Swiper](http://idangero.us/swiper/).

* Add `swiper.min.js` into **/js/** folder;
* Add `swiper.min.css` into **/css/** folder;
* Enqueue Swiper Slider, add this code into **functions.php**:
	```
	/**
	 * SwiperSlider: modern mobile touch slider with hardware accelerated transitions and native behavior
	 * http://idangero.us/swiper/
	 */
	function grc2018_swiper() {
		if ( ! is_admin() ) {
			// Enqueue SwiperSlider JavaScript
			wp_register_script('js_swiper', get_template_directory_uri(). '/js/swiper.min.js', array() );
			wp_enqueue_script('js_swiper');
			// Enqueue SwiperSlider Stylesheet
			wp_register_style( 'swiper-style', get_template_directory_uri() . '/css/swiper.min.css', 'all' );
			wp_enqueue_style( 'swiper-style' );
		}
	}
	add_action('init', 'grc2018_swiper');
	```

* Add image support into **functions.php**
	```
	add_image_size( 'grc2018-swiper-slide-image', 2000, 600, true );
	```
* Implement Swiper script into **/scripts/main.js**
	```
	// SwiperSlider custom settings
	<script>
	  var mySwiper = new Swiper('.swiper-container', {
	      // Optional parameters
	      // direction: 'vertical',
	      direction: 'horizontal',
	      loop: true,

	      // If we need pagination
	      pagination: {
	          el: '.swiper-pagination',
	      },

	      // Navigation arrows
	      navigation: {
	          nextEl: '.swiper-button-next',
	          prevEl: '.swiper-button-prev',
	      },

	      // And if we need scrollbar
	      scrollbar: {
	          el: '.swiper-scrollbar',
	      },
	  })
	</script>
	// end SwiperSlider custom settings
	```

* Create a file **/template-parts/header/swiper-slider-post.php**
* Paste in this code:
	```
	<!-- Swiper Slider main container -->
	<div class="swiper-container">

			<!-- Additional required wrapper -->
			<div class="swiper-wrapper">

				<?php
				// Get all published posts
				$args = array(
					'numberposts' => 3, // Display up to 3 posts.
					'orderby' => 'date',
					'order' => 'DESC',
					'suppress_filters' => true
				);
				$postQuery = get_posts($args);

				foreach( $postQuery as $post ) : setup_postdata($post);

					if ( has_post_thumbnail() ) { ?>
						<div class="swiper-slide">
							<a href="<?php echo get_permalink(); ?>" title="<?php echo the_title(); ?>" rel="bookmark">
								<?php the_post_thumbnail('grc2018-swiper-slide-image'); ?>
								<p class="swiper-caption"><?php the_title(); ?></p>
							</a>
						</div>
					<?php
					}
				endforeach; ?>

			</div>

			<!-- If we need pagination -->
			<div class="swiper-pagination"></div>

			<!-- If we need navigation buttons -->
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>

			<!-- If we need scrollbar -->
			<!-- <div class="swiper-scrollbar"></div> -->

	</div>
	```
* Output the slider into **index.php** before the `<main>` container
	```
	<?php
		// Check if this is the front page and that it is not page 2 or higher
		if ( is_front_page() && !is_paged() ) {
			// Add featured content slider
			get_template_part( 'template-parts/header/swiper-slider-post' );
		}
	?>
	```

### Add Customizer Options for Swiper Slider
* Edit `/inc/customizer.php`
* Add a Theme Section
```
$wp_customize->add_section(
	'theme_options', array(
		'title'	=> __( 'Theme Options', 'grc2018' ),
		'priority'	=> 130, // Before Additional CSS.
		'capability'	=> 'edit_theme_options',
		'description'	=> __( 'Toggle on/off Recent Posts Swiper Slider' ),
	)
);
```
* Add settings for Swiper Slider
```
$wp_customize->add_setting(
	'swiper_slider', array(
		'default'	=> '',
		'transport'	=> 'postMessage',
		'type'	=> 'theme_mod',
		'sanitize_callback'	=> 'grc2018_sanitize_swiperslider',
	)
);
```
* Add controls for Swiper Slider
```
$wp_customize->add_control(
	'swiper_slider', array(
		'type'	=> 'radio',
		'description'	=> __( 'Create an automatic slider on the homepage with the latest 3 posts' ),
		'label'	=> __( 'Swiper Slider', 'grc2018' ),
		'choices'	=> array(
			''	=> __( 'On (default)', 'grc2018' ),
			'none'	=> __( 'Off', 'grc2018' ),
		),
		'section'	=> 'theme_options',
		'settings'	=> 'swiper_slider', // Match setting ID from above
		'priority'	=> 5,
	)
);
```
* Sanitize the input controls
```
function grc2018_sanitize_swiperslider( $input ) {
	$valid = array(
		''	=> __( 'On', 'grc2018' ),
		'none'	=> __( 'Off', 'grc2018' ),
	);
	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	}
	return '';
}
```
* Implement controls logic
```
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
```
* Edit `/inc/customizer.js`
```
wp.customize( 'swiper_slider', function( value ) {
	value.bind( function( to ) {
		// $('.swiper-container').css( 'display', to );
			$( '.swiper-container' ).css( {
				'display': to
			} );
	} );
} );
```

## Main Content

**Note** Move all the template-parts into sub-folders for header, navigation, page, post, footer

### Masonry grid layout
[Getting Started with Masonry](https://masonry.desandro.com/).

* Enqueue Masonry, add this code into **functions.php**:
	```
	/**
	 * Masonry: a JavaScript grid layout library.
	 * It works by placing elements in optimal position based on available vertical space,
	 * sort of like a mason fitting stones in a wall.
	 * https://masonry.desandro.com/
	 */
	function grc2018_masonry() {
	    wp_enqueue_script( 'jquery-masonry' );
	}
	add_action( 'wp_enqueue_scripts', 'grc2018_masonry' );
	```

* Implement Masonry script into **/scripts/main.js**
	```
	// Masonry custom settings
	$('.grid').masonry({
		// options
		itemSelector: '.grid-item',
		isAnimated: true,
		// columnWidth: 200,
		// use outer width of grid-sizer for columnWidth
		columnWidth: '.grid-sizer',
		percentPosition: true
	});
	// end Masonry custom settings
	```
* Assign the class `.grid` to `<main id="main" class="site-main grid">` in **index.php**
* Add an empty div after the opening `<main>` container tag
	```
	<!-- GRC add empty container only for masonry-grid -->
	<!-- .grid-sizer empty element, only used for element sizing -->
	<div class="grid-sizer"></div>
	```
* Add the class `.grid-item` to each post `<article id="post-<?php the_ID(); ?>" <?php post_class('grid-item'); ?>>` into **/template-parts/content.php**
* Create sass file for Masonry Grid
* `/elements/_masonry-grid.scss` and enqueue it in `style.scss` as `@import "elements/masonry-grid"`
* Implement basic header's styles in `/elements/_masonry-grid.scss`
	```
	/**
	 * Masonry Grid
	 * https://masonry.desandro.com/
	 * https://masonry.desandro.com/extras.html#bootstrap
	 */
	.grid {
		/* 4 columns by default */
		.grid-sizer {
			width: 25%;
		}
		.grid-item {
			width: rem(350);
			border: 1px $grey solid;
			float: left;
			margin: 0 rem(20) rem(20) 0;
		}
	}
	.grid .entry-title,
	.grid .entry-meta,
	.grid .entry-content,
	.grid .entry-footer {
		margin: rem(20)
	}
	```

### Post Featured Images

* Add image support into **functions.php**
	```
	add_image_size( 'grc2018-featured-image', 2000, 1200, true );
	```
* Output featured image just below the `<header>` in `/template-parts/content.php`
	```
	<!-- GRC verifiy if featured image exists -->
	<?php
	// if it is on the index page wrap it in a link
	if ( has_post_thumbnail() && ! is_single() ) : ?>
		<figure class="featured-image">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail('grc2018-featured-image'); ?>
				</a>
		</figure>
	<?php
	// if it is a single post do not link to the post itself
	elseif ( has_post_thumbnail() ) : ?>
		<figure class="featured-image full-bleed">
			<?php the_post_thumbnail('grc2018-featured-image'); ?>
		</figure>
	<?php
	endif; ?><!-- end if featured image exists -->
	```

### WordPress Dashboard editor

**Note** This does not work with the **Gutenberg** editor

* Create a file `editor-style.css` into `/inc/editor-style.css`
* Add/Enqueue Dasboard Editor style into `functions.php`
	```
	add_editor_style( 'inc/editor-style.css' );
	```
* Add some styles into `editor-style.css`

### Comments Pagination

* Add `comments pagination` snippet to **comments.php**
	```
	<div class="comments-pagination pagination">
	    <?php paginate_comments_links(); ?>
	</div>
	```