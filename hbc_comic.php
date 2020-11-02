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
}

add_action( 'admin_init','hbc_comicCanvas');

function get_custom_post_type_template( $single_template ) {
    global $post;

    if (  $post->post_type == 'comic' ) {
        $single_template = dirname( __FILE__ ) . '/single-hbc_comic.php';
        wp_register_style('hbc_comicCanvas', plugins_url('css/hbc_comicCanvas.css',__FILE__));
        wp_enqueue_style('hbc_comicCanvas');
        wp_register_script( 'hbc_comicCanvas', plugins_url('js/hbc_comicCanvas.js', __FILE__));
        wp_enqueue_script('hbc_comicCanvas');
    }

    return $single_template;
}
add_filter( 'single_template', 'get_custom_post_type_template' );



function my_editor_content( $content, $post ) {
if( $post->post_type =='comic') {
            $content = 'comic';
    }

    return $content;
}
add_filter( 'default_content', 'my_editor_content', 10, 2 );

?>
