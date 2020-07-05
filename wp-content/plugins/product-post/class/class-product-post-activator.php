<?php

class Product_Post_Activator {


	public static function activate() {

		// Installed version number
	    update_option( 'product_post_version', PRODUCT_POST_VERSION );
		
		flush_rewrite_rules();

	}

}