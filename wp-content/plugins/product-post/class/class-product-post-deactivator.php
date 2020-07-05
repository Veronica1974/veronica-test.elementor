<?php

class Product_Post_Deactivator {

	public static function deactivate() {

		flush_rewrite_rules();

	}

}
