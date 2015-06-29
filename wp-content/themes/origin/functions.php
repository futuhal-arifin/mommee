<?php
/**
 * @package Origin
 * @subpackage Functions
 * @version 0.5.6
 * @author AlienWP
 * @link http://alienwp.com
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

/* Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
$theme = new Hybrid();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'origin_theme_setup' );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 */
function origin_theme_setup() {

	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-styles', array( 'style' ) );
	add_theme_support( 'hybrid-core-menus', array( 'primary' ) );
	add_theme_support( 'hybrid-core-sidebars', array( 'primary', 'subsidiary', 'after-singular' ) );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-theme-settings', array( 'footer' ) );
	add_theme_support( 'hybrid-core-meta-box-footer' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-template-hierarchy' );
	add_theme_support( 'hybrid-core-scripts', array( 'drop-downs' ) );	

	/* Add theme support for framework extensions. */
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'cleaner-gallery' );
	add_theme_support( 'breadcrumb-trail' );

	/* Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );

	/* Embed width/height defaults. */
	add_filter( 'embed_defaults', 'origin_embed_defaults' );

	/* Filter the sidebar widgets. */
	add_filter( 'sidebars_widgets', 'origin_disable_sidebars' );
        
	/* Image sizes */
	add_action( 'init', 'origin_image_sizes' );

	/* Excerpt ending */
	add_filter( 'excerpt_more', 'origin_excerpt_more' );
 
	/* Custom excerpt length */
	add_filter( 'excerpt_length', 'origin_excerpt_length' );    
        
	/* Filter the pagination trail arguments. */
	add_filter( 'loop_pagination_args', 'origin_pagination_args' );
	
	/* Filter the comments arguments */
	add_filter( "{$prefix}_list_comments_args", 'origin_comments_args' );	
	
	/* Filter the commentform arguments */
	add_filter( 'comment_form_defaults', 'origin_commentform_args', 11, 1 );
	
	/* Enqueue scripts (and related stylesheets) */
	add_action( 'wp_enqueue_scripts', 'origin_scripts' );
	
	/* Add the breadcrumb trail just after the container is open. */
	add_action( "{$prefix}_close_header", 'breadcrumb_trail' );
	
	/* Breadcrumb trail arguments. */
	add_filter( 'breadcrumb_trail_args', 'origin_breadcrumb_trail_args' );
	
	
	add_filter('wp_nav_menu', 'add_nav_class');

	//  Register navigation menus
	register_nav_menus (
		array(
			'secondary'	=> __( 'Secondary', 'wpex' )
		)
	);

	/* Add support for custom headers. */
	$args = array(
		'width'         => 235,
		'height'        => 70,
		'flex-height'   => true,
		'flex-width'    => true,		
		'header-text'   => false,
		'uploads'       => true,
	);
	add_theme_support( 'custom-header', $args );	
	
	/* Add support for custom backgrounds */
	add_theme_support( 'custom-background' );
	    
	/* Default footer settings */
	add_filter( "{$prefix}_default_theme_settings", 'origin_default_footer_settings' );

	/* Add theme settings to the customizer. */
	require_once( trailingslashit( get_template_directory() ) . 'admin/customize.php' );

	/* Remove the "Theme Settings" submenu. */
	add_action( 'admin_menu', 'origin_remove_theme_settings_submenu', 11 );	

	/** 
	* Disqus plugin: use higher priority.
	* URL: http://themehybrid.com/support/topic/weird-problem-wit-disqus-plugin 
	*/
	if( function_exists( 'dsq_comments_template' ) ) :
		remove_filter( 'comments_template', 'dsq_comments_template' );
		add_filter( 'comments_template', 'dsq_comments_template', 11 );
	endif;		
	
}

/**
 * Disables sidebars if viewing a one-column page.
 *
 */
function origin_disable_sidebars( $sidebars_widgets ) {
	
	global $wp_query;
	
	    if ( is_page_template( 'page-template-fullwidth.php' ) ) {
		    $sidebars_widgets['primary'] = false;
	    }

	return $sidebars_widgets;
}

/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.  This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 */
function origin_embed_defaults( $args ) {
	
	$args['width'] = 640;
		
	if ( is_page_template( 'page-template-fullwidth.php' ) )
		$args['width'] = 940;

	return $args;
}

/**
 * Excerpt ending 
 *
 */
function origin_excerpt_more( $more ) {	
	return '...';
}

/**
 *  Custom excerpt lengths 
 *
 */
function origin_excerpt_length( $length ) {
	return 40;
}

/**
 * Enqueue scripts (and related stylesheets)
 *
 */
function origin_scripts() {
	
	if ( !is_admin() ) {
		
		/* Enqueue Scripts */
		
		wp_register_script( 'origin_fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox-1.3.4.pack.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'origin_fancybox' );
		
		wp_register_script( 'origin_fitvids', get_template_directory_uri() . '/js/fitvids/jquery.fitvids.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'origin_fitvids' );
		
		wp_register_script( 'origin_footer-scripts', get_template_directory_uri() . '/js/footer-scripts.js', array( 'jquery', 'origin_fitvids', 'origin_fancybox' ), '1.0', true );
		wp_enqueue_script( 'origin_footer-scripts' );

		wp_enqueue_script( 'origin_navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20130228', true );		

		/* Enqueue Styles */
		wp_enqueue_style( 'origin_fancybox-stylesheet', get_template_directory_uri() . '/js/fancybox/jquery.fancybox-1.3.4.css', false, 1.0, 'screen' );		
	}
}

/**
 * Pagination args 
 *
 */
function origin_pagination_args( $args ) {
	
	$args['prev_text'] = __( '&larr; Previous', 'origin' );
	$args['next_text'] = __( 'Next &rarr;', 'origin' );

	return $args;
}

/**
 *  Image sizes
 *
 */
function origin_image_sizes() {
	add_image_size( 'single-thumbnail', 636, 310, true ); 
}

/**
 *  Unregister Hybrid widgets
 *
 */
function origin_unregister_widgets() {
	
	unregister_widget( 'Hybrid_Widget_Search' );
	register_widget( 'WP_Widget_Search' );	
}

/**
 * Custom comments arguments
 * 
 */
function origin_comments_args( $args ) {
	
	$args['avatar_size'] = 50;
	return $args;
}

/**
 *  Custom comment form arguments
 * 
 */
function origin_commentform_args( $args ) {
	
	global $user_identity;

	/* Get the current commenter. */
	$commenter = wp_get_current_commenter();

	/* Create the required <span> and <input> element class. */
	$req = ( ( get_option( 'require_name_email' ) ) ? ' <span class="required">' . __( '*', 'origin' ) . '</span> ' : '' );
	$input_class = ( ( get_option( 'require_name_email' ) ) ? ' req' : '' );
	
	
	$fields = array(
		'author' => '<p class="form-author' . $input_class . '"><input type="text" class="text-input" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" size="40" /><label for="author">' . __( 'Name', 'origin' ) . $req . '</label></p>',
		'email' => '<p class="form-email' . $input_class . '"><input type="text" class="text-input" name="email" id="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="40" /><label for="email">' . __( 'Email', 'origin' ) . $req . '</label></p>',
		'url' => '<p class="form-url"><input type="text" class="text-input" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="40" /><label for="url">' . __( 'Website', 'origin' ) . '</label></p>'
	);
	
	$args = array(
		'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field' => '<p class="form-textarea req"><!--<label for="comment">' . __( 'Comment', 'origin' ) . '</label>--><textarea name="comment" id="comment" cols="60" rows="10"></textarea></p>',
		'must_log_in' => '<p class="alert">' . sprintf( __( 'You must be <a href="%1$s" title="Log in">logged in</a> to post a comment.', 'origin' ), wp_login_url( get_permalink() ) ) . '</p><!-- .alert -->',
		'logged_in_as' => '<p class="log-in-out">' . sprintf( __( 'Logged in as <a href="%1$s" title="%2$s">%2$s</a>.', 'origin' ), admin_url( 'profile.php' ), esc_attr( $user_identity ) ) . ' <a href="' . wp_logout_url( get_permalink() ) . '" title="' . esc_attr__( 'Log out of this account', 'origin' ) . '">' . __( 'Log out &rarr;', 'origin' ) . '</a></p><!-- .log-in-out -->',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'id_form' => 'commentform',
		'id_submit' => 'submit',
		'title_reply' => __( 'Leave a Reply', 'origin' ),
		'title_reply_to' => __( 'Leave a Reply to %s', 'origin' ),
		'cancel_reply_link' => __( 'Click here to cancel reply.', 'origin' ),
		'label_submit' => __( 'Post Comment &rarr;', 'origin' ),
	);
	
	return $args;
}

/**
 * Breadcrumb trail arguments.
 *
 */
function origin_breadcrumb_trail_args( $args ) {

	$args['before'] = '';
	$args['separator'] = '&raquo;';
	$args['show_on_front'] = false;
	
	return $args;
}

/**
 * Default footer settings
 *
 */
function origin_default_footer_settings( $settings ) {
    
    $settings['footer_insert'] = '<p class="copyright">' . __( 'Copyright &#169; [the-year] [site-link]', 'origin' ) . '</p>' . "\n\n" . '<p class="credit">' . __( 'Powered by [wp-link] and [theme-link]', 'origin' ) . '</p>';
    
    return $settings;
}

/**
 * Origin site title.
 *
 */
function origin_site_title() {

	$tag = ( is_front_page() ) ? 'h1' : 'div';

	if ( get_header_image() ) {

		echo '<' . $tag . ' id="site-title">' . "\n";
			echo '<a href="' . get_home_url() . '" title="' . get_bloginfo( 'name' ) . '" rel="Home">' . "\n";
				echo '<img class="logo" src="' . get_header_image() . '" alt="' . get_bloginfo( 'name' ) . '" />' . "\n";
			echo '</a>' . "\n";
		echo '</' . $tag . '>' . "\n";
	
	} elseif ( hybrid_get_setting( 'origin_logo_url' ) ) { // check for legacy setting
			
		echo '<' . $tag . ' id="site-title">' . "\n";
			echo '<a href="' . get_home_url() . '" title="' . get_bloginfo( 'name' ) . '" rel="Home">' . "\n";
				echo '<img class="logo" src="' . esc_url( hybrid_get_setting( 'origin_logo_url' ) ) . '" alt="' . get_bloginfo( 'name' ) . '" />' . "\n";
			echo '</a>' . "\n";
		echo '</' . $tag . '>' . "\n";
	
	} else {
	
		hybrid_site_title();
	
	}
}

/**
 * Remove the "Theme Settings" submenu.
 *
 * @since 0.5
 */
function origin_remove_theme_settings_submenu() {

	/* Remove the Theme Settings settings page. */
	remove_submenu_page( 'themes.php', 'theme-settings' );
}

function add_nav_class($output) {
	
	if (strpos($output, 'menu-primary-items') !== false):
		$links = explode("<a ", $output);
		$output = $links[0];
		$count = 0;
	
	
		foreach ($links as $link) {
			if ($count > 0) {
				$link = preg_replace('/href=/', '<a class="navi' . $count . '" href=', $link, 1);
				$output .= $link; 			
			}
			
			$count++;
		}
	endif;
		
	return $output;
}


/**
 * Recent_Posts widget w/ category exclude class
 * This allows specific Category IDs to be removed from the Sidebar Recent Posts list
 *
 */
class WP_Widget_Recent_Posts_Exclude extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "The most recent posts on your site") );
		parent::__construct('recent-posts', __('Recent Posts with Exclude'), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_recent_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;
 		$exclude = empty( $instance['exclude'] ) ? '' : $instance['exclude'];

		$r = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'category__not_in' => explode(',', $exclude) ));
		if ($r->have_posts()) :
?>
		<?php //echo print_r(explode(',', $exclude)); ?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
		<?php  while ($r->have_posts()) : $r->the_post(); ?>
		<li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['exclude'] = strip_tags( $new_instance['exclude'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$exclude = esc_attr( $instance['exclude'] );
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php _e( 'Exclude Category(s):' ); ?></label> <input type="text" value="<?php echo $exclude; ?>" name="<?php echo $this->get_field_name('exclude'); ?>" id="<?php echo $this->get_field_id('exclude'); ?>" class="widefat" />
			<br />
			<small><?php _e( 'Category IDs, separated by commas.' ); ?></small>
		</p>
<?php
	}
}

function WP_Widget_Recent_Posts_Exclude_init() {
    unregister_widget('WP_Widget_Recent_Posts');
    register_widget('WP_Widget_Recent_Posts_Exclude');
}

add_action('widgets_init', 'WP_Widget_Recent_Posts_Exclude_init');

?>