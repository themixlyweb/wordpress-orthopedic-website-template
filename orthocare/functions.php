<?php
/**
 * orthocare functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package orthocare
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function orthocare_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on orthocare, use a find and replace
		* to change 'orthocare' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'orthocare', get_template_directory() . '/languages' );

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
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'orthocare' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'orthocare_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'orthocare_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function orthocare_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'orthocare_content_width', 640 );
}
add_action( 'after_setup_theme', 'orthocare_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function orthocare_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'orthocare' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'orthocare' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'orthocare_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function orthocare_scripts() {
	wp_enqueue_style( 'orthocare-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'orthocare-style', 'rtl', 'replace' );

	wp_enqueue_script( 'orthocare-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'orthocare_scripts' );

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


require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'orthocare_register_required_plugins' );

function orthocare_register_required_plugins() {

    $plugins = array(
        array(
            'name'      => 'Elementor',
            'slug'      => 'elementor',
            'required'  => true,
        ),
        array(
            'name'      => 'Pro Elements',
            'slug'      => 'pro-elements',
            'source'    => 'https://github.com/proelements/proelements/releases/download/v3.32.1/pro-elements.zip', // optional (if not on wp.org)
            'required'  => true,
            'external_url' => 'https://proelements.org/', // fallback
        ),
    );

    $config = array(
        'id'           => 'orthocare',           // unique ID
        'menu'         => 'tgmpa-install-plugins',
        'parent_slug'  => 'themes.php',
        'capability'   => 'edit_theme_options',
        'has_notices'  => true,
        'dismissable'  => false,
        'is_automatic' => true,
        'message'      => __( 'This theme requires the following plugins to work properly:', 'orthocare' ),
    );

    tgmpa( $plugins, $config );
}



// Register Shortcode: [ortho_sidebar]
function ortho_sidebar_shortcode() {
    ob_start();

    $output = '';

    // 1️⃣ POPULAR POSTS SECTION
    $popular_posts = new WP_Query(array(
        'posts_per_page' => 3,
        'orderby'        => 'comment_count', // Change to 'meta_value_num' if you use post views
        'order'          => 'DESC',
    ));

    $output .= '<div class="ortho-sidebar">';

    $output .= '<h3 class="sidebar-title">Popular Posts</h3>';
    $output .= '<div class="popular-posts">';

    if ($popular_posts->have_posts()) :
        while ($popular_posts->have_posts()) : $popular_posts->the_post();
            $output .= '<div class="popular-post-item">';
            if (has_post_thumbnail()) {
                $output .= '<div class="popular-thumb"><a href="' . get_permalink() . '">' . get_the_post_thumbnail(get_the_ID(), 'thumbnail') . '</a></div>';
            }
            $output .= '<div class="popular-content">';
            $output .= '<a href="' . get_permalink() . '" class="popular-title">' . get_the_title() . '</a>';
            $output .= '<div class="popular-date"><i class="far fa-calendar-alt"></i> ' . get_the_date('d M Y') . '</div>';
            $output .= '</div></div>';
        endwhile;
        wp_reset_postdata();
    else :
        $output .= '<p>No popular posts found.</p>';
    endif;

    $output .= '</div>';

    // 2️⃣ CATEGORIES SECTION
    $output .= '<h3 class="sidebar-title">Categories</h3>';
    $output .= '<ul class="sidebar-categories">';
    $categories = get_categories(array('hide_empty' => 0)); // show empty too

    foreach ($categories as $cat) {
        $output .= '<li><a href="' . get_category_link($cat->term_id) . '">' . esc_html($cat->name) . ' (' . $cat->count . ')</a></li>';
    }
    $output .= '</ul>';

    // 3️⃣ TAGS SECTION
    $tags = get_tags();
    if ($tags) {
        $output .= '<h3 class="sidebar-title">Tags</h3>';
        $output .= '<div class="sidebar-tags">';
        foreach ($tags as $tag) {
            $output .= '<a href="' . get_tag_link($tag->term_id) . '"># ' . esc_html($tag->name) . '</a>';
        }
        $output .= '</div>';
    }

    $output .= '</div>'; // .ortho-sidebar

    return $output . ob_get_clean();
}
add_shortcode('ortho_sidebar', 'ortho_sidebar_shortcode');

// Shortcode: [pages_sitemap]
function custom_pages_sitemap_shortcode() {
    $output = '';

    // Fetch all published pages
    $pages = get_pages(array(
        'sort_column' => 'menu_order, post_title',
        'sort_order'  => 'ASC',
        'post_status' => 'publish'
    ));

    // Organize pages by parent
    $page_tree = array();
    foreach ($pages as $page) {
        $page_tree[$page->post_parent][] = $page;
    }

    // Recursive function to build <ul><li> list
    function build_page_list($parent_id, $page_tree) {
        $html = '';
        if (isset($page_tree[$parent_id])) {
            $html .= '<ul>';
            foreach ($page_tree[$parent_id] as $page) {
                $html .= '<li>';
                $html .= '<a href="' . get_permalink($page->ID) . '">' . esc_html($page->post_title) . '</a>';
                $html .= build_page_list($page->ID, $page_tree);
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
        return $html;
    }

    $output .= '<div class="pages-sitemap">';
    $output .= build_page_list(0, $page_tree);
    $output .= '</div>';

    return $output;
}
add_shortcode('pages_sitemap', 'custom_pages_sitemap_shortcode');
