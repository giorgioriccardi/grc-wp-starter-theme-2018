<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GRC_2018
 */

?>

<!-- <article id="post-<?php // the_ID(); ?>" <?php // post_class(); ?>> -->
<!-- GRC Masonry Grid class -->
<article id="post-<?php the_ID(); ?>" <?php post_class('grid-item'); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
				grc2018_posted_on();
				grc2018_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php
	endif; ?>
	</header><!-- .entry-header -->

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

	<div class="entry-content">
		<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'grc2018' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'grc2018' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php grc2018_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
