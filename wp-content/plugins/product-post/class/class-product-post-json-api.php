<?php
//https://veronica-test.elementor.cloud/?rest_route=/product-post/v1/author/1s
class Product_Post_Json_Api extends WP_REST_Controller {
	protected $plugin_name;
	protected $version;
	protected $namespace;
	
	public function __construct() {
	    $this->plugin_name = $plugin_name;
	    $this->version = $version;
	    $this->namespace = 'product-post/v1';

	}

	
	public function category_rest_rout_by_id(){
	    register_rest_route( $this->namespace, '/terms/(?P<term_id>\d+)', array(
	        'methods'  =>  WP_REST_Server::READABLE,
	        'callback' =>  array($this, get_category_data_by_id),
	    ) );

	}
	
	
	public function category_rest_rout_by_name(){
	    register_rest_route( $this->namespace, '/terms/(?P<name>\d+)', array(
	        'methods'  =>  WP_REST_Server::READABLE,
	        'callback' =>  array($this, get_category_data_by_name),
	    ) );
	    
	}
	
	public function get_category_data_by_id(WP_REST_Request $request){
	    global $wpdb;
	    
	    $sql = " SELECT wp.id FROM ".$wpdb->terms." wt
	    INNER JOIN ".$wpdb->term_taxonomy." wtt ON wtt.term_id = wt.term_id
	    INNER JOIN ".$wpdb->term_relationships." wtr ON wtr.term_taxonomy_id = wtt.term_taxonomy_id
	    INNER JOIN ".$wpdb->posts." wp ON wp.ID = wtr.object_id
	    LEFT  JOIN ".$wpdb->term_relationships." wtt1 ON wtt1.parent = wtt.term_id
	    WHERE wp.post_type = 'product_acf' and wt.term_id = ".$request['term_id'];
	    $results = $wpdb->get_results( $sql, OBJECT );
	    $posts = get_posts( array(
	        'author' => (int) $request['id'],
	    ) );
	    
	    if ( empty( $posts ) )
	        return new WP_Error( 'no_author_posts', 'no records', array( 'status' => 404 ) );
	        
	        return $results;
	}
	
	public function get_category_data_by_name(WP_REST_Request $request){
	    global $wpdb;
	   
	    $sql = " SELECT wp.id FROM wp_terms wt
	    INNER JOIN wp_term_taxonomy wtt ON wtt.term_id = wt.term_id
	    INNER JOIN wp_term_relationships wtr ON wtr.term_taxonomy_id = wtt.term_taxonomy_id
	    INNER JOIN wp_posts wp ON wp.ID = wtr.object_id
	    LEFT JOIN wp_term_taxonomy wtt1 ON wtt1.parent = wtt.term_id
	    WHERE wp.post_type = 'product_acf' and wt.name = ".$request['name'];
	    $results = $wpdb->get_results( $sql, OBJECT );
	    $posts = get_posts( array(
	        'author' => (int) $request['id'],
	    ) );
	    
	    if ( empty( $posts ) )
	        return new WP_Error( 'no_author_posts', 'no records', array( 'status' => 404 ) );
	        
	        return $results;
	}

}
