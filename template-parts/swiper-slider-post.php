<?php

// Custom loop for post items in the slider on the front page.
// Slider will show up to 3 posts

?>

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
