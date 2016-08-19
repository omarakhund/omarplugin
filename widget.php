<?php
/* Plugin Name: omarplugin
Plugin URI: https://twitter.com/omarzaffar
Description: Shotcode for Assignment 1 - CCT460
Author: Omar Akhund
Author URI: https://twitter.com/omarzaffar
Version: 1.0
*/

/*
Omar Akhund - Assignment 2 - 
Shortcodes and custom post type
*/
 
//Enqueuing stylesheet to style shortcode
function styleplugin(){
	wp_enqueue_style('plugin-style', plugins_url('/css/style.css', __FILE__));
	}
add_action( 'wp_enqueue_scripts', 'styleplugin' );



//Widget code starts
class omarwidget extends WP_Widget {
    public function __construct() {
    $widget_ops    = array(
    'classname'    => 'widget_postblock',
    'description'  => __( 'Shows 2 posts from the custom post type:pdf') );
    parent::__construct('show_custompost', __('Custom Post', 'pdf'), $widget_ops);
               }
    public function widget ( $args, $instance ) {
    ?>
  
  <div id="widgetstyle" role="main">
    
  <?php
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $wp_query = new WP_Query();
  $wp_query->query('post_type=pdf&posts_per_page=2' . '&paged=' . $paged);
  ?>
 
<?php if ($wp_query->have_posts()) : ?>
 
               <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
 
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <div id="gridlayout">
                <?php the_title();?>
                <?php the_post_thumbnail('medium'); ?></a>
                </div>
                </article>
                
                <?php endwhile; ?>
                <?php endif; ?>
        </div>
    <?php
    
               }
 
}
 
add_action( 'widgets_init', function(){
     register_widget( 'omarwidget' );
});



//Shortcode code starts
//This shortcode helps users to get in touch with the author faster by clicking on their social media links

//creates a shortcode for facebook
function facebook_button( $atts ) {
    extract( shortcode_atts(
      array(
        'color' => '',
        'button' => '',
        'title' => 'Facebook',
        'link'  => 'https://www.facebook.com/',
      ), $atts )
    );
  return '<style> .link_button a {color: ' . $color . ';} .link_button  {background: ' . $button . ';}</style>' .
  '<span class="individualist_button"><button class="link_button"><a href=" ' . $link . '">' . $title . '</a></button></span>';
  }
  add_shortcode ( 'twitter_button', 'twitter_button');

  //creates a shortcode for twitter
  function twitter_button( $atts ) {
    extract( shortcode_atts(
      array(
        'color' => '',
        'button' => '',
        'title' => 'Twitter',
        'link'  => 'https://www.twitter.com/',
      ), $atts )
    );
  return '<style> .link_button a {color: ' . $color . ';} .link_button  {background: ' . $button . ';}</style>' .
  '<span class="individualist_button"><button class="link_button"><a href=" ' . $link . '">' . $title . '</a></button></span>';
  }
  add_shortcode ( 'twitter_button', 'twitter_button');


  //creates a shortcode for linkedin
  function linkedin_button( $atts ) {
    extract( shortcode_atts(
      array(
        'color' => '',
        'button' => '',
        'title' => 'LinkedIn',
        'link'  => 'https://www.linkedin.com/',
      ), $atts )
    );
  return '<style> .link_button a {color: ' . $color . ';} .link_button  {background: ' . $button . ';}</style>' .
  '<span class="individualist_button"><button class="link_button"><a href=" ' . $link . '">' . $title . '</a></button></span>';
  }
  add_shortcode ( 'linked_button', 'linked_button');


//custom post type code begins. Code reference: http://www.wpbeginner.com/wp-tutorials/how-to-create-custom-post-types-in-wordpress/
function omar_cpt() {
    register_post_type( 'pdf',
    // CPT Option
        array(
            'labels' => array(
                'name' => __( 'Pakistan Development Fund' ),
                'singular_name' => __( 'PDF' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'pdf'),
        )
    );
}

// Hooking up our function to theme setup
add_action( 'init', 'omar_cpt' );

function omar_custom() {
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'PDF', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'PDFs', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'Pakistan Development Fund', 'twentythirteen' ),
        'parent_item_colon'   => __( 'Parent pdf', 'twentythirteen' ),
        'all_items'           => __( 'All projects', 'twentythirteen' ),
        'view_item'           => __( 'View project', 'twentythirteen' ),
        'add_new_item'        => __( 'Add new project', 'twentythirteen' ),
        'add_new'             => __( 'Add New', 'twentythirteen' ),
        'edit_item'           => __( 'Edit Project', 'twentythirteen' ),
        'update_item'         => __( 'Update Project', 'twentythirteen' ),
        'search_items'        => __( 'Search Project', 'twentythirteen' ),
        'not_found'           => __( 'Not Found', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
    );

// Set other options for Custom Post Type
    $args = array(
        'label'               => __( 'projects', 'twentythirteen' ),
        'description'         => __( 'pdf news and media', 'twentythirteen' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy.
        'taxonomies'          => array( 'genres' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );

    register_post_type( 'pdf', $args );

}

add_action( 'init', 'omar_custom', 0 );


add_action( 'pre_get_posts', 'add_my_post_types_to_query' );
function add_my_post_types_to_query( $query ) {
    if ( is_home() && $query->is_main_query() )
        $query->set( 'post_type', array( 'post', 'pdf' ) );
    return $query;
}
?>
 
  


