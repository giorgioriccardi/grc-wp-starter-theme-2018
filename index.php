<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GRC_2018
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<!-- Swiper Slider -->
		<?php
			// Check if this is the front page and that it is not page 2 or higher
			if ( is_front_page() && !is_paged() ) {
				// Add featured content slider
				get_template_part( 'template-parts/swiper-slider-post' );
			}
		?>
		<!-- end Swiper Slider -->

		<!-- Masonry Grid -->
		<main id="main" class="site-main grid">

			<!-- GRC add empty container only for masonry-grid -->
			<!-- .grid-sizer empty element, only used for element sizing -->
  		<div class="grid-sizer"></div>

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			// GRC Move posts navigation outside <main> container
			// the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
		<!-- end Masonry Grid -->

		<!-- GRC Move posts navigation outside <main> container -->
		<?php the_posts_navigation(); ?>

	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
