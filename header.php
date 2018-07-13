<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'amp_reviews' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$amp_reviews_description = get_bloginfo( 'description', 'display' );
			if ( $amp_reviews_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $amp_reviews_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav
			id="site-navigation"
			class="main-navigation"
			<?php if ( amp_reviews_is_amp() ) : ?>
				[class]=" siteNavigationMenuExpanded ? 'main-navigation toggled' : 'main-navigation' "
			<?php endif; ?>
		>
			<?php if ( amp_reviews_is_amp() ) : ?>
				<amp-state id="siteNavigationMenuExpanded">
					<script type="application/json">false</script>
				</amp-state>
			<?php endif; ?>

			<button
				class="menu-toggle"
				aria-controls="primary-menu"
				aria-expanded="false"
				<?php if ( amp_reviews_is_amp() ) : ?>
					on="tap:AMP.setState( { siteNavigationMenuExpanded: ! siteNavigationMenuExpanded } )"
					[aria-expanded]="siteNavigationMenuExpanded ? 'true' : 'false'"
				<?php endif; ?>
			>
				<?php esc_html_e( 'Primary Menu', 'amp_reviews' ); ?>
			</button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">