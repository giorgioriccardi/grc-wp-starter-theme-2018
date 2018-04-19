# How to, step by step from the initial `_s`

This document assumes that the Pantheon (or any other given dev environment) is already up and running and that [Yeoman](https://bitbucket.org/giorgioriccardi/templates-linters.git) template is installed and ready to be compiled in the new starter theme root.

## Initial front-dev setup in WordPress Dashboard
Create a starter theme package using [Underscores `_s`](https://underscores.me/), follow instructions on the doc page, just make sure to
select all the advanced options available, especially `SASS` files.

Give it a meaningful name, for this prototype is `GRC 2018` (slug: `grc2018`).

**For the sake of this prototype I will not support `WooCommerce` features right away**.

## Initial Theme Build
* Install Google Fonts after selecting them from the Google site;
copy the generated Fonts url [Dosis|Kavivanar](https://fonts.googleapis.com/css?family=Dosis:400,700|Kavivanar)
* Enqueue the above fonts into **functions.php** in the functions section `grc2018_scripts()`
```
wp_enqueue_style( 'grc2018-fonts', 'https://fonts.googleapis.com/css?family=Dosis:400,700|Kaviva
nar' );
```
* Setup the proper `_scss` file to render the new fonts in `./app/styles/variables-site/_typography.scss`
* ~~Adding control for web fonts and improve performance with preconnect for Google Fonts is skipped for this initial phase of development~~
* Create responsive typography:
	* in `./app/styles/typography/_typography.scss` we implement a media query to make the font slightly smaller below `< 767px` screen width
	* `@include font-size(0.9);`
	* `@media screen and (min-width: 768px) { @include font-size(1); }`
	* create each size for `H1` to `H6` in `./app/styles/typography/_headings.scss`
* Initial setup for responsive layout:
	* change the order how styles get rendered by the WP theme, making sure that the content styles `@import "site/site"` are imported before the widgets styles `@import "site/secondary/widgets"`
	* create a new sass file under `/layout/_global.scss` and add it in the `/site/_site.scss` as `@import "../layout/global"`
	* create some initial mediaquery variables in `/variables-site/_structures.scss` such as `$query__small: 600px` and `$query__medium: 900px`
	* assign some mediaquery rules to content in `/layout/_global.scss`

## Header styles and functionality
.... in progress

### Swiper Slider
[Getting Started With Swiper](http://idangero.us/swiper/).

Add `swiper.min.js` into **./js/** folder;

Add `swiper.min.css` into **./css/** folder;

Enqueue Swiper Slider, add this code into **functions.php**:
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

Implement Swiper script into **./scripts/main.js**
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

create a file **swiper-slider-post.php**
paste this code:
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
							<?php the_post_thumbnail('feature-slider'); ?>
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

Output the slider into **index.php**
```
<?php
	// Check if this is the front page and that it is not page 2 or higher
	if ( is_front_page() && !is_paged() ) {
		// Add featured content slider
		get_template_part( 'template-parts/swiper-slider-post' );
	}
?>
```

### Masonry grid layout
[Masonry](https://masonry.desandro.com/).

Add 'masonry.pkgd.min.js' into **./js/** folder;

Enqueue Masonry, add this code into **functions.php**:
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

Implement Masonry script into **./scripts/main.js**
```
// Masonry custom settings
$('.grid').masonry({
	// options
	itemSelector: '.grid-item',
	isAnimated: true,
	columnWidth: 200
});
// end Masonry custom settings
```