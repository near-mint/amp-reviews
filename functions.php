<?php
/**
 * amp_reviews functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package amp_reviews
 */

if ( ! function_exists( 'amp_reviews_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function amp_reviews_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'amp_reviews', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'amp_reviews' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'amp_reviews_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/*
		 * If you intend your theme to be used with the AMP plugin and make use of AMP components in your templates,
		 * then you should make sure your site is served in native/canonical AMP via:
		 *
		 *   add_theme_support( 'amp' );
		 *
		 * If you implement <amp-live-list> in your comments.php then you should do:
		 *
		 *   add_theme_support( 'amp', array(
		 *       'comments_live_list' => true,
		 *   );
		 *
		 * Otherwise, a user of the AMP plugin can decide via an admin screen for whether or not they want to serve
		 * your theme's templates in AMP responses, either in native AMP (canonical URLs) or paired AMP modes
		 * (separate AMP-specific URLs).
		 */
	}
endif;
add_action( 'after_setup_theme', 'amp_reviews_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function amp_reviews_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'amp_reviews_content_width', 640 );
}
add_action( 'after_setup_theme', 'amp_reviews_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function amp_reviews_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'amp_reviews' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'amp_reviews' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'amp_reviews_widgets_init' );

/**
 * Determine whether this is an AMP response.
 *
 * Note that this must only be called after the parse_query action.
 *
 * @link https://github.com/Automattic/amp-wp
 * @return bool Is AMP endpoint (and AMP plugin is active).
 */
function amp_reviews_is_amp() {
	return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}

/**
 * Enqueue styles.
 */
function amp_reviews_styles() {
	wp_enqueue_style( 'amp-reviews-style', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'amp_reviews_styles' );

/**
 * Enqueue scripts.
 *
 * This short-circuits in AMP because custom scripts are not allowed. There are AMP equivalents provided elsewhere.
 *
 * navigation:
 *     In AMP the :focus-within selector is used to keep submenus displayed while tabbing,
 *     and amp-bind is used to managed the toggled state of the nav menu on small screens.
 *
 * skip-link-focus-fix:
 *     This is not implemented in AMP because it only relates to IE11, a browser which now has a very small market share.
 *
 * comment-reply:
 *     Support for comment replies is provided by the AMP plugin.
 */
 
function amp_reviews_scripts() {
	if ( amp_reviews_is_amp() ) {
		return;
	}

	wp_enqueue_script( 'amp-reviews-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'amp-reviews-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'amp_reviews_scripts' );


/*
 * Add Custom post types
 */
function amp_reviews_custom_post_types() {

	// Here we go, this is the only thing you need to modify to registers your CPTs:
	// write inside this array ($types) an array for each CPT you want
	// (and if you need only one CPT simply let one array)
	$types = array(
  
	  // Books
	  array('type'          => 'review',
			'typePlural'    => 'reviews',
			'labelSingle'   => 'Review',
			'labelPlural'   => 'Reviews'
		),
  
	);
  
	// This foreach loops the $types array and creates labels and arguments for each CPTs
	foreach ($types as $type) {
  
	  $typeSingle = $type['type'];
	  $typePlural = $type['typePlural'];
	  $labelSingle = $type['labelSingle'];
	  $labelPlural = $type['labelPlural'];
  
	  // Labels: here you can translate the strings in your language.
	  // These strings will be displayed in the admin panel
	  $labels = array(
		'name'               => _x( $labelPlural, ' post type general name' ),
		'singular_name'      => _x( $labelSingle, ' post type singular name' ),
		'add_new'            => _x( 'Add new ', $labelSingle ),
		'add_new_item'       => __( 'Add new '. $labelSingle ),
		'edit_item'          => __( 'Edit '. $labelSingle ),
		'new_item'           => __( 'New '. $labelSingle ),
		'all_items'          => __( 'All '. $labelPlural ),
		'view_item'          => __( 'View '. $labelSingle ),
		'search_items'       => __( 'Search '. $labelPlural ),
		'not_found'          => __( 'No '. $labelSingle .' found' ),
		'not_found_in_trash' => __( 'No '. $labelSingle .' found in trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => __( $labelPlural ),
	  );
  
	  // Arguments (some settings, to learn more see WordPress docs)
	  $args = array(
		'labels'        => $labels,
		'description'   => 'Individual reviews of things',
		'public'        => true,
		'supports'      => array( 'title', 'author', 'editor', 'thumbnail', 'excerpt', 'comments', 'page-attributes', 'custom-fields' ),
		'has_archive'   => false,
		'menu_position' => 5,
		'rewrite'       => true, // default
		'menu_icon'     => 'dashicons-randomize'//get_template_directory_uri().'/assets/img/cpt-'.$typeSingle.'.png'
	  );
  
	  // Finally, we can registers the post types
	  register_post_type( $typeSingle, $args );
  
	} // end foreach
  
  }
  add_action( 'init', 'amp_reviews_custom_post_types' );

// Show posts of 'post', 'page', 'review' post types on home page
function search_filter( $query ) {
	if ( !is_admin() && $query->is_main_query() ) {
	  if ( $query->is_search ) {
		$query->set( 'post_type', array( 'post', 'page', 'review' ) );
	  }
	}
  }
   
  add_action( 'pre_get_posts','search_filter' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

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

function getRatings() {
	//TODO: get rubric from something dynamic

	$rubric = ['Cheesiness','Heat','Flavor','Viscosity','Chips'];

	//TODO: Remove dependency on Font Awesome... local SVGs... maybe of chips!

	$html = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">'
		. '<dl>';

	for($x = 0; $x < count($rubric); $x++) {
		$html .= ''
			. '<dt class="ratingRubric">' . $rubric[$x] . '</dt>'
			. '<dd class="ratingValue">' . starsHtml(get_post_custom_values($rubric[$x])[0]) . '</dd>';
	}

	$html .= '</dl>';

	return $html;
}