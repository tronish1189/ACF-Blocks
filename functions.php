<?php
/**
 * tpf functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tpf
 */

/* -- START CUSTOM FUNCTIONS -- */

/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function wpexplorer_add_dashboard_widgets() {
	wp_add_dashboard_widget(
		'wpexplorer_dashboard_widget', // Widget slug.
		'Website Documentation', // Title.
		'wpexplorer_dashboard_widget_function' // Display function.
	);
	wp_add_dashboard_widget(
		'technical_support', // Widget slug.
		'Technical Support', // Title.
		'tech_dashboard_widget_function' // Display function.
	);
}
add_action( 'wp_dashboard_setup', 'wpexplorer_add_dashboard_widgets' );

/**
 * Create the function to output the contents of your Dashboard Widget.
 */
function wpexplorer_dashboard_widget_function() {
	echo "<a target='_blank' href='https://docs.google.com/document/d/1fgOr3NEM_V0p6sdZhvzCieJHtaANIuDTRAm1QfH5_9s/edit?usp=sharing'>Google Doc</a> (only editable by Milo Media)<br><a target='_blank' href='https://drive.google.com/file/d/1KGrgKyR5gTX6s7VEjlLAukzYET4Y9pQo/view?usp=sharing'>PDF</a>";
}
function tech_dashboard_widget_function() {
	echo "For technical assistance with this website, please contact:<br><br>
	Michael Lopetrone<br>
	Milo Media<br>
	<a href='https://www.milomedia.co'>https://www.milomedia.co</a><br>
	313-327-2820";
}

// Remove dashboard widgets
function remove_dashboard_meta() {
	if ( ! current_user_can( 'manage_options' ) ) {
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
      remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
	}
}
add_action( 'admin_init', 'remove_dashboard_meta' );

// Custom Admin footer
function wpexplorer_remove_footer_admin () {
	echo '<span id="footer-thankyou">Built by <a href="https://www.milomedia.co" target="_blank">Milo Media</a></span>';
}
add_filter( 'admin_footer_text', 'wpexplorer_remove_footer_admin' );

/*
 * Function for post duplication. Dups appear as drafts. User is redirected to the edit screen
 */
function rd_duplicate_post_as_draft(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}

	/*
	 * Nonce verification
	 */
	if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
		return;

	/*
	 * get the original post id
	 */
	$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );

	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;

	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {

		/*
		 * new post data array
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);

		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );

		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}

		/*
		 * duplicate all post meta just in two SQL queries
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				if( $meta_key == '_wp_old_slug' ) continue;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}


		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );

/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
	}
	return $actions;
}

add_filter('page_row_actions', 'rd_duplicate_post_link', 10, 2);

// CUSTOM ADMIN LOGIN HEADER LOGO

function my_custom_login_logo()
{
    echo '<style  type="text/css"> h1 a {  background-image:url(' . get_bloginfo('template_directory') . '/img/tpf-logo-color.png)  !important;     background-size: 250px !important;     height: 130px !important;     width: 250px !important;} </style>';
}
add_action('login_head',  'my_custom_login_logo');

function tpf_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'tpf',
				'title' => __( 'TPF', 'tpf' ),
			),
		)
	);
}
add_filter( 'block_categories', 'tpf_block_category', 10, 2);
/*Register blocks*/
function register_acf_block_types() {

  acf_register_block_type(array(
    'name'              => 'two-col-img-img',
    'title'             => __('2 Column - Image Image'),
    'description'       => __('A two column component with two images'),
    'render_template'   => 'template-parts/blocks/two-column-img-img/two-column-img-img.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'list' ),
  ));


  acf_register_block_type(array(
    'name'              => 'two-col-text-img',
    'title'             => __('2 Column - Text Image'),
    'description'       => __('A two column component with text and an image'),
    'render_template'   => 'template-parts/blocks/two-column-text-img/two-column-text-img.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'list' ),
  ));


  acf_register_block_type(array(
    'name'              => 'staff-list',
    'title'             => __('Staff List'),
    'description'       => __('A list of staff members, their photos, and bios'),
    'render_template'   => 'template-parts/blocks/staff-list/staff-list.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'list' ),
  ));

  acf_register_block_type(array(
    'name'              => 'text-block',
    'title'             => __('Text Block'),
    'description'       => __('A block of text with an optional heading'),
    'render_template'   => 'template-parts/blocks/text-block-1/text-block.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'tiles' ),
  ));

  acf_register_block_type(array(
    'name'              => 'accordion',
    'title'             => __('Accordion'),
    'description'       => __('A an accordion block'),
    'render_template'   => 'template-parts/blocks/accordion/accordion.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'tiles' ),
  ));

  acf_register_block_type(array(
    'name'              => 'contact-block',
    'title'             => __('Contact Block'),
    'description'       => __('A 2-column block with text intended to display contact info'),
    'render_template'   => 'template-parts/blocks/contact-block/contact-block.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'tiles' ),
  ));
  acf_register_block_type(array(
    'name'              => 'staff-tiles',
    'title'             => __('Staff Tiles'),
    'description'       => __('A collection of staff members'),
    'render_template'   => 'template-parts/blocks/staff-tiles/staff-tiles.php',
    'category'          => 'tpf',
    'icon'              => 'admin-comments',
		'mode' => 'edit',
    'keywords'          => array( 'staff', 'tiles' ),
  ));
    acf_register_block_type(array(
      'name'              => 'blog-tiles',
      'title'             => __('Blog Tiles'),
      'description'       => __('A collection of blog posts in tiles'),
      'render_template'   => 'template-parts/blocks/blog-tiles/blog-tiles.php',
      'category'          => 'tpf',
      'icon'              => 'admin-comments',
		'mode' => 'edit',
      'keywords'          => array( 'blog', 'tiles' ),
    ));

    acf_register_block_type(array(
        'name'              => 'hero-nav',
        'title'             => __('Hero Nav'),
        'description'       => __('A hero image alongside navigation for a page'),
        'render_template'   => 'template-parts/blocks/hero-nav/hero-nav.php',
        'category'          => 'tpf',
        'icon'              => 'admin-comments',
		'mode' => 'edit',
        'keywords'          => array( 'hero', 'nav' ),
    ));

    acf_register_block_type(array(
        'name'              => 'hero-featured',
        'title'             => __('Hero Featured'),
        'description'       => __('A hero image with text spanning the full width of the page'),
        'render_template'   => 'template-parts/blocks/hero-featured/hero-featured.php',
        'category'          => 'tpf',
        'icon'              => 'admin-comments',
		'mode' => 'edit',
        'keywords'          => array( 'hero', 'featured' ),
    ));
}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'register_acf_block_types');
}

/*Add Options Pages */
if( function_exists('acf_add_options_page') ) {

 acf_add_options_page(array(
   'page_title' 	=> 'Footer Settings',
   'menu_title'	=> 'Footer',
   'menu_slug' 	=> 'footer-settings',
   'capability'	=> 'edit_posts',
   'redirect'		=> false
 ));
}

/*NAV STUFF*/
// Register Custom Navigation Walker
require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';

// This theme uses wp_nav_menu() in one location.
register_nav_menus( array(
	'header' => 'Header menu'
) );

/* Add Clases to nav */
function add_classes_afg($classes, $item, $args) {
  $classes[] = 'px-1';
  return $classes;
}
add_filter('nav_menu_css_class','add_classes_afg',1,3);

/*Register Custom logo*/
 function change_logo_class( $html ) {
     $html = str_replace( 'custom-logo-link', 'navbar-brand', $html );
     return $html;
 }
 add_filter( 'get_custom_logo', 'change_logo_class', 10);

 // Register Custom Post Type
function staff() {

	$labels = array(
		'name'                  => 'Staff',
		'singular_name'         => 'Staff',
		'menu_name'             => 'Staff',
		'name_admin_bar'        => 'Staff',
		'archives'              => 'Item Archives',
		'attributes'            => 'Item Attributes',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Staff Members',
		'add_new_item'          => 'Add New Staff Member',
		'add_new'               => 'Add New Staff Member',
		'new_item'              => 'New Item',
		'edit_item'             => 'Edit Staff Member',
		'update_item'           => 'Update Item',
		'view_item'             => 'View Item',
		'view_items'            => 'View Items',
		'search_items'          => 'Search Item',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Staff Image',
		'set_featured_image'    => 'Set Staff Image',
		'remove_featured_image' => 'Remove Staff Image',
		'use_featured_image'    => 'Use as Staff Image',
		'insert_into_item'      => 'Insert into item',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Staff',
		'description'           => 'Collection of Staff',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
    	'menu_icon' => 'dashicons-businesswoman',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
    'taxonomies'            => array ('category')
	);
	register_post_type( 'staff', $args );

}
add_action( 'init', 'staff', 0 );

/* -- END CUSTOM FUNCTION --*/

if ( ! function_exists( 'tpf_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function tpf_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on tpf, use a find and replace
		 * to change 'tpf' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'tpf', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'tpf' ),
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
		add_theme_support( 'custom-background', apply_filters( 'tpf_custom_background_args', array(
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
	}
endif;
add_action( 'after_setup_theme', 'tpf_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tpf_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'tpf_content_width', 640 );
}
add_action( 'after_setup_theme', 'tpf_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tpf_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'tpf' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'tpf' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'tpf_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tpf_scripts() {
	wp_enqueue_style( 'tpf-style', get_stylesheet_uri() );

	wp_enqueue_script( 'tpf-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'tpf-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tpf_scripts' );

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
