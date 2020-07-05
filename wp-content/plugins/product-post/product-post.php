<?php
/**
 * Plugin Name:       Product Post
 * Description:       Product Post
 * Version:           0.0.1
 * Author:            Veronica
 * Text Domain:       product-post
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
/**
 * Currently plugin version.
 * Rename this for your plugin and update it as you release new versions.
 */
if ( !defined( 'PRODUCT_POST_VERSION' ) ) {
    define( 'PRODUCT_POST_VERSION', '0.0.1' );
}
   

/**
 * The code that runs during plugin activation.
 * This action is documented in class/class-product-post-activator.php
 */
function activate_product_post()
{
    require_once plugin_dir_path( __FILE__ ) . 'class/class-product-post-activator.php';
    Product_Post_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in class/class-product-post-deactivator.php
 */
function deactivate_product_post()
{
    require_once plugin_dir_path( __FILE__ ) . 'class/class-product-post-deactivator.php';
    Product_Post_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_product_post' );
register_deactivation_hook( __FILE__, 'deactivate_product_post' );

require plugin_dir_path( __FILE__ ) . 'class/class-product-post.php';


function run_product_post()
{
    $plugin = new Product_Post();
    $plugin->run();
}

run_product_post();