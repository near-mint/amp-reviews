<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				_s_posted_on();
				_s_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="ratings">
		<?php 

			//TODO: get rubric from something dynamic

			$rubric = ['Cheesiness','Heat','Flavor','Viscosity','Chips'];

			function starsHtml($rating) {
				//TODO: Check a11y

				$html = '';

				for ($n = 1; $n <= 5; $n++) {
					if ($n <= $rating) {
						$html .= '<span class="fa fa-star checked"></span>';
					}
					else {
						$html .= '<span class="fa fa-star"></span>';
					}
				}

				return $html;
			}
			
			//TODO: Remove dependency on Font Awesome... local SVGs... maybe of chips!

			$html = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">'
				. '<dl>';

			for($x = 0; $x < count($rubric); $x++) {
				$html .= ''
					. '<dt class="ratingRubric">' . $rubric[$x] . '</dt>'
					. '<dd class="ratingValue">' . starsHtml(get_post_custom_values($rubric[$x])[0]) . '</dd>';
			}
			
			$html .= '</dl>';

			//TODO: Wrap this whole thing in a conditional

			if (in_category('review')) {
				echo $html;
			}

		?>
	</div>
	<?php _s_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'amp_reviews' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'amp_reviews' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php _s_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->