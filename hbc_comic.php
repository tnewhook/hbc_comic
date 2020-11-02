<?php
/*
Plugin Name: HBC Comic Post Type
Description: Add post types for Comic Strips
Author: Trevor Newhook
*/
// Hook <strong>hbc_comic()</strong> to the init action hook
add_action( 'init', 'hbc_comic' );
// The custom function to register a Comic Strip post type

function hbc_comic(){
// Set the labels, this variable is used in the $args array
$labels = array(
'name'               => __( 'Comic Strips' ),
'singular_name'      => __( 'Comic Strip' ),
'add_new'            => __( 'Add New Comic Strip' ),
'add_new_item'       => __( 'Add New Comic Strip' ),
'edit_item'          => __( 'Edit Comic Strip' ),
'new_item'           => __( 'New Comic Strip' ),
'all_items'          => __( 'All Comic Strips' ),
'view_item'          => __( 'View Comic Strip' ),
'search_items'       => __( 'Search Comic Strip' ),
'featured_image'     => 'Poster',
'set_featured_image' => 'Add Poster'
);

// The arguments for our post type, to be entered as parameter 2 of register_post_type()
$args = array(
'labels'            => $labels,
'description'       => 'Holds our Comic Strip specific data',
'public'            => true,
'menu_position'     => 5,
'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
'has_archive'       => false,
'show_in_admin_bar' => true,
'show_in_nav_menus' => false,
'query_var'         => true,
);
// Call the actual WordPress function
// Parameter 1 is a name for the post type
// Parameter 2 is the $args array
register_post_type( 'comic', $args);

}

function hbc_comicCanvas() {
  if (  'comic' === $post->post_type) {
    wp_register_style('hbc_comicCanvas', plugins_url('css/hbc_comicCanvas.css',__FILE__));
    wp_enqueue_style('hbc_comicCanvas');
    wp_register_script( 'hbc_comicCanvas', plugins_url('js/hbc_comicCanvas.js', __FILE__));
    wp_enqueue_script('hbc_comicCanvas');
  }
}

add_action( 'admin_init','hbc_comicCanvas');

add_filter( 'single_template', 'get_hbc_comic_template' );
function get_hbc_comic_template( $single ) {
  global $post;
  if( $post->post_type =='comic') {
        // if you're here, you're on a singlar page for your costum post
        // type and WP did NOT locate a template, use your own.
        return plugin_dir_path(__FILE__).'/single-comic.php';
    }
    return $template;
}


function hbc_comic_editor_content( $content, $post ) {
if( $post->post_type =='comic') {
            $content = 'comic<br />';
            $content .=plugins_url('css/hbc_comicCanvas.css',__FILE__);
            $content .='<br>woot: '.plugins_url('/single-comic.php', __FILE__);


    }

    return $content;
}
add_filter( 'default_content', 'hbc_comic_editor_content', 10, 2 );


function hbc_comic_editor_scripts($hook_suffix) {
  $cpt='comic';
  if( in_array($hook_suffix, array('post.php', 'post-new.php') ) ){
       $screen = get_current_screen();
       if( is_object( $screen ) && $cpt == $screen->post_type ){
         wp_register_script( 'hbc_comic_editor', plugins_url( 'js/hbc_comic_editor.js', __FILE__ ));
         wp_enqueue_script( 'hbc_comic_editor' );
         wp_register_style ('hbc_comic_editor', plugins_url( 'css/hbc_comic_editor.css', __FILE__ ));
         wp_enqueue_style( 'hbc_comic_editor' );
       }
   }
}
add_action( 'admin_enqueue_scripts', 'hbc_comic_editor_scripts' );

add_action( 'edit_form_after_title', 'hbc_comic_editor_form_after_title' );
function hbc_comic_editor_form_after_title() {
  $cpt='comic';
  global $wp;
  global $pagenow;
  if($pagenow=='post.php'|| $pagenow== 'post-new.php'){
     $screen = get_current_screen();
     if( is_object( $screen ) && $cpt == $screen->post_type ){
       echo '<h2>This is edit_form_after_title!</h2>';
       echo '<br />page slug:'.$pagenow;
     }
  }
  //*/
}
?>
