<?php
class Product_Post {

	protected $loader;
	protected $plugin_name;
	protected $version;

	public function __construct() {
		if ( defined( 'PRODUCT_POST_VERSION' ) ) {
		    $this->version = PRODUCT_POST_VERSION;
		} else {
			$this->version = '0.0.1';
		}
		$this->plugin_name = 'product-post';

		$this->load_dependencies();
		
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	
	private function load_dependencies() {
	
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'class/class-product-post-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'class/class-product-post-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'class/class-product-post-public.php';

		$this->loader = new Product_Post_Loader();
	}

	
	private function define_admin_hooks() {
		$plugin_admin = new Product_Post_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );


		// call custom post types
		$this->loader->add_action( 'init', $plugin_admin, 'register_product_post' );

		$this->loader->add_action('add_meta_boxes',$plugin_admin, 'gallary_add_custom_meta_box', 10,2);
		$this->loader->add_action('save_post',$plugin_admin, 'product_img_gallery_save');
		
		$this->loader->add_action('add_meta_boxes',$plugin_admin, 'price_add_custom_meta_box',10,2);
		$this->loader->add_action('save_post',$plugin_admin, 'product_price_save');
		
		$this->loader->add_action('add_meta_boxes',$plugin_admin, 'forsale_add_custom_meta_box',10,2);
		$this->loader->add_action('save_post',$plugin_admin, 'product_forsale_save');
		
		$this->loader->add_action( 'add_meta_boxes',$plugin_admin,'video_add_custom_box' );
		$this->loader->add_action( 'save_post',$plugin_admin, 'youtube_save_postdata' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Product_Post_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		// Add the shortchode
		$this->loader->add_shortcode( 'gallary_product_post', $plugin_public, 'gallary_per_post' );
		$this->loader->add_shortcode( 'display_product_price', $plugin_public, 'display_product_price' );
		$this->loader->add_shortcode( 'display_main_title', $plugin_public, 'display_main_title' );
	}

	
	public function run() {
		$this->loader->run();
	}

	
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	
	public function get_loader() {
		return $this->loader;
	}

	
	public function get_version() {
		return $this->version;
	}
	

	public function product_post_uninstall_cleanup () {
		delete_option( 'product_post_version' );
	
		$sql = "DELETE posts, terms, meta
		FROM " . $wpdb->posts . " posts
		LEFT JOIN " . $wpdb->term_relationships . " terms
			ON ( posts.ID = terms.object_id )
		LEFT JOIN " . $wpdb->postmeta . " meta
			ON ( posts.ID = meta.post_id )
		WHERE posts.post_type in ( 'product_asf );";
	
		$wpdb->get_results( $sql, OBJECT );
	}
}
