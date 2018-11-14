<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<div class="ratings">
		<?php 

			//TODO: get rubric from something dynamic

			$rubric = ['Value','Cheesiness','Heat'];

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

			echo $html;

		?>
	</div>

	<?php _s_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'amp_reviews' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'amp_reviews' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->