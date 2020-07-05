<?php 

add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_styles' );
function child_theme_enqueue_styles() {
    $parenthandle = 'parent-style'; // This is 'twentytwenty-style' for the Twenty Twenty theme.
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css',
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
        );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
        );
}

 function hide_admin_side_bar() {
    if (current_user_can('editor')) {
        add_filter('show_admin_bar','__return_false');
    }
}
add_action('wp_head','hide_admin_side_bar'); 

function shocode_filter($postid){
    $gallary =  do_shortcode('[gallary_product_post id="'.$postid.'"]');
    $price =  do_shortcode('[display_product_price id="'. $postid .'"]'); 
    
    return $gallary . $price;
}

add_filter( 'the_product_content', 'shocode_filter', 10,1 );

function shotcode_title($postid){
    $title = do_shortcode('[display_main_title id="'. $postid.'" sinular="sinular"]');
    return $title;
}

 //add_filter( 'the_title', 'shotcode_title', 10, 1);
?>