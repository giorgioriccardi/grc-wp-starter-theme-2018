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
		<main id="main" class="site-main">

			<!-- Slider main container -->
			<div class="swiper-container">
			    <!-- Additional required wrapper -->
			    <div class="swiper-wrapper">
			        <!-- Slides -->
			        <div class="swiper-slide">
								<img src="https://farm7.staticflickr.com/6213/6256961398_a484813abe_b.jpg" />
								<p class="swiper-caption">Slide 1</p>
							</div>
			        <div class="swiper-slide">
								<img src="https://farm7.staticflickr.com/6025/6012928351_d643e5a404_b.jpg" />
								<p class="swiper-caption">Slide 2</p>
							</div>
			        <div class="swiper-slide">
								<img src="https://farm6.staticflickr.com/5159/5874760659_de4c00d585_b.jpg" />
								<p class="swiper-caption">Slide 3</p>
							</div>
							<div class="swiper-slide">
								<img src="https://farm8.staticflickr.com/7384/8730654121_05bca33388_z.jpg" />
								<p class="swiper-caption">Slide 4</p>
							</div>
			    </div>

			    <!-- If we need pagination -->
			    <div class="swiper-pagination"></div>

			    <!-- If we need navigation buttons -->
			    <div class="swiper-button-prev"></div>
			    <div class="swiper-button-next"></div>

			    <!-- If we need scrollbar -->
			    <!-- <div class="swiper-scrollbar"></div> -->
			</div>

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

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
