<?php

class Product_Post_Admin
{
  
    private  $plugin_name ;  
    private  $version ;
   
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
 
    public function cpt_image_box()
    {
        // Move the image metabox from the sidebar to the normal position
        $screens = array( 'product_acf' );
        remove_meta_box( 'postimagediv', $screens, 'side' );
        add_meta_box(
            'postimagediv',
            __( 'Front of Card Image', 'product-post' ),
            'post_thumbnail_meta_box',
            $screens,
            'side',
            'default'
        );
        // Move the image metabox from the sidebar to the normal position
        $screens = array( 'co_readings' );
        remove_meta_box( 'postimagediv', $screens, 'side' );
        add_meta_box(
            'postimagediv',
            __( 'Back of Card Image', 'product-post' ),
            'post_thumbnail_meta_box',
            $screens,
            'side',
            'default'
        );
        //remove Astra metaboxes from our cpt
        $screens = array(
            'product_acf',
            'co_readings',
            'co_positions',
            'co_descriptions'
        );
        remove_meta_box( 'astra_settings_meta_box', $screens, 'side' );
        // Remove Astra Settings in Posts
        add_meta_box(
            'back-metabox',
            __( 'Previous Page', 'product-post' ),
            array( $this, 'render_back_button_metabox' ),
            $screens,
            'side',
            'high'
        );
    }
    
  
    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/product-post-admin.css',
            array(),
            $this->version,
            'all'
        );
    }
    
   
    public function enqueue_scripts()
    {
     
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'js/product-post-admin.js',
            array( 'jquery' ),
            $this->version,
            false
        );
    }
    
   

    public function register_product_post()
    {
        $co_admin_icon = 'data:image/svg+xml;base64,' . base64_encode( '<svg height="100px" width="100px"  fill="black"
			xmlns:x="http://ns.adobe.com/Extensibility/1.0/"
			xmlns:i="http://ns.adobe.com/AdobeIllustrator/10.0/"
			xmlns:graph="http://ns.adobe.com/Graphs/1.0/"
			xmlns="http://www.w3.org/2000/svg"
			xmlns:xlink="http://www.w3.org/1999/xlink"
			version="1.1" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100"
			xml:space="preserve"><g><g i:extraneous="self">
			<circle fill="black" cx="49.926" cy="57.893" r="10.125"></circle>
			<path fill="black" d="M50,78.988c-19.872,0-35.541-16.789-36.198-17.503l-1.95-2.12l1.788-2.259c0.164-0.208,4.097-5.142,
				10.443-10.102 C32.664,40.296,41.626,36.751,50,36.751c8.374,0,17.336,3.546,25.918,10.253c6.346,4.96,10.278,9.894,
				10.443,10.102l1.788,2.259 l-1.95,2.12C85.541,62.2,69.872,78.988,50,78.988z M20.944,59.019C25.56,63.219,36.99,
				72.238,50,72.238 c13.059,0,24.457-9.013,29.061-13.214C74.565,54.226,63.054,43.501,50,43.501C36.951,43.501,25.444,
				54.218,20.944,59.019z"></path>
			<path fill="black" d="M44.305,30.939L50,21.075l5.695,9.864c3.002,0.427,6.045,1.185,9.102,2.265L50,7.575L35.203,33.204
				C38.26,32.124,41.303,31.366,44.305,30.939z"></path>
			<path fill="black" d="M81.252,74.857L87.309,85H12.691l6.057-10.143c-2.029-1.279-3.894-2.629-5.578-3.887L1,92h98L86.83,
				70.97 C85.146,72.228,83.28,73.578,81.252,74.857z"></path>
			</g></g></svg>' );
       
        $labels = array(
            'name'               => __( 'Product Post', 'product-post' ),
            'singular_name'      => __( 'Product Post', 'product-post' ),
            'add_new'            => __( 'Add New Product Post', 'product-post' ),
            'add_new_item'       => __( 'Add New Product Post', 'product-post' ),
            'edit_item'          => __( 'Edit Product Post', 'product-post' ),
            'new_item'           => __( 'New Product Post', 'product-post' ),
            'all_items'          => __( 'All Product Post', 'product-post' ),
            'view_item'          => __( 'View Product Post', 'product-post' ),
            'search_items'       => __( 'Search Product Post', 'product-post' ),
            'featured_image'     => __( 'Product Post Image', 'product-post' ),
            'set_featured_image' => __( 'Add Product Post Image', 'product-post' ),
            
        );
        // Settings for our post type
        $args = array(
            'description'       => 'Holds our Product Post information',
            'has_archive'       => false,
            'hierarchical'      => true,
            'labels'            => $labels,
            'menu_icon'         => $co_admin_icon, //'dashicons-media-default',
            'menu_position'     => 42,
            'public'            => true,
            'show_in_menu'      => true,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'supports'          => array( 'title', 'editor', 'thumbnail' ),
            'query_var'         => true,
            'taxonomies'         => array('category', 'post_tag'),
        );
        register_post_type( 'product_acf', $args );
       
    }
    
    public function gallary_add_custom_meta_box($post_type, $post) {
        add_meta_box(
            'product_custom_meta_box', // $id
            'Product Galary Fields', // $title
            array($this,'product_print_box'), // $callback
            'product_acf', // $page
            'normal', // $context
            'high'); // $priority
    }
    
    
    public function product_image_uploader_field( $name, $value = '' ) {
        
        $image = 'Upload Image';
        $button = 'button';
        $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
        $display = 'none'; // display state of the "Remove image" button
        
        ?>
     
    <p><?php
        _e( '<i>Set Images for Featured Image Gallery</i>', 'product_post' );
    ?></p>
     
    <label>
        <div class="gallery-screenshot clearfix">
            <?php
            {
                $ids = explode(',', $value);
                foreach ($ids as $attachment_id) {
                    $img = wp_get_attachment_image_src($attachment_id, 'thumbnail');
                    echo '<div class="screen-thumb"><img src="' . esc_url($img[0]) . '" /></div>';
                }
            }
            ?>
        </div>
         
        <input id="edit-gallery" class="button upload_gallery_button" type="button"
               value="<?php esc_html_e('Add/Edit Gallery', 'product_post') ?>"/>
        <input id="clear-gallery" class="button upload_gallery_button" type="button"
               value="<?php esc_html_e('Clear', 'product_post') ?>"/>
        <input type="hidden" name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($name); ?>" class="gallery_values" value="<?php echo esc_attr($value); ?>">
    </label>
<?php   
    }


    public function product_print_box($post) {
       
        wp_nonce_field( 'save_product_gallery', 'product_gallery_nonce' );
        
        $meta_key = 'second_featured_img';
        echo $this->product_image_uploader_field( $meta_key, get_post_meta($post->ID, $meta_key, true) );
    }
        
        
     public function product_img_gallery_save( $post_id ) {
            
            if ( !isset( $_POST['product_gallery_nonce'] ) ) {
                return $post_id;
            }
            
            if ( !wp_verify_nonce( $_POST['product_gallery_nonce'], 'save_product_gallery') ) {
                return $post_id;
            }
            
            if ( isset( $_POST[ 'second_featured_img' ] ) ) {
                update_post_meta( $post_id, 'second_featured_img', esc_attr($_POST['second_featured_img']) );
            } else {
                update_post_meta( $post_id, 'second_featured_img', '' );
            }
            
        }
        
        public function price_add_custom_meta_box() {
            add_meta_box(
                'product_custom_price_meta_box', // $id
                'Product Price Fields', // $title
                array($this,'product_price_print_box'), // $callback
                'product_acf', // $page
                'normal', // $context
                'high'); // $priority
        }
        
        public function product_price_print_box($post) {
           
            wp_nonce_field( 'save_product_price', 'product_price_nonce' );
            
            $meta_key = 'product_custom_price';
            echo $this->product_price_uploader_field( $meta_key, get_post_meta($post->ID, $meta_key, true) );
        
        }
        
        public function product_price_uploader_field( $name, $value = '' ) {
            
            ?>
     
            <p><?php
                _e( '<i>Product Post Price</i>', 'product_post' );
            ?></p>
             
            <label>
                 
                <input id="<?php echo esc_attr($name); ?>" class="price upload_price" type="number" name="<?php echo esc_attr($name); ?>"
                       value="<?php echo esc_attr($value); ?>"/>
                
            </label>
        <?php   
        }
           
        
    
    public function product_price_save( $post_id ) {
        
        if ( !isset( $_POST['product_price_nonce'] ) ) {
            return $post_id;
        }
        
        if ( !wp_verify_nonce( $_POST['product_price_nonce'], 'save_product_price') ) {
            return $post_id;
        }
        
        if ( isset( $_POST[ 'product_custom_price' ] ) ) {
            update_post_meta( $post_id, 'product_custom_price', esc_attr($_POST['product_custom_price']) );
        } else {
            update_post_meta( $post_id, 'product_custom_price', '' );
        }
        
    }
       
    public function forsale_add_custom_meta_box() {
        add_meta_box(
            'product_custom_forsale_meta_box', // $id
            'Product For Sale Fields', // $title
            array($this,'product_forsale_print_box'), // $callback
            'product_acf', // $page
            'normal', // $context
            'high'); // $priority
    }
    
    public function product_forsale_print_box($post) {     
        wp_nonce_field( 'save_product_forsale', 'product_forsale_nonce' );      
        $meta_key = 'second_featured_forsale';
        echo $this->product_forsale_uploader_field( $meta_key, get_post_meta($post->ID, $meta_key, true) );       
    }
    
    public function product_forsale_uploader_field( $name, $value = '' ) {
        /* var_dump($value);
        die(); */
        ?>
     
    <p><?php
        _e( '<i>Product Post For Sale</i>', 'product_post' );
        
    ?></p>
     
    <label>
         
        <input id="<?php echo esc_attr($name); ?>" class="forsale upload_price" type="checkbox" name="<?php echo esc_attr($name); ?>"
               value="1" <?php if(!empty($value)) echo 'checked';?> />
        
    </label>
<?php   
    }
    
   
    public function product_forsale_save( $post_id ) {
        
        if ( !isset( $_POST['product_forsale_nonce'] ) ) {
            return $post_id;
        }
        
        if ( !wp_verify_nonce( $_POST['product_forsale_nonce'], 'save_product_forsale') ) {
            return $post_id;
        }
        
        if ( !empty( $_POST[ 'second_featured_forsale' ] ) ) {
            
            update_post_meta( $post_id, 'second_featured_forsale', esc_attr($_POST['second_featured_forsale']) );
        } else {
            
            update_post_meta( $post_id, 'second_featured_forsale', '0' );
        }
        
    }
    
    public function video_add_custom_box() {
        add_meta_box(
            'video_meta_box', // $id
            'Youtube Vide', // $title
            array($this,'youtube_custom_box'), // $callback
            'product_acf', // $page
            'normal', // $context
            'high'); // $priority
    }
    
    public function youtube_custom_box( $post ) {
        wp_nonce_field( plugin_basename( __FILE__ ), 'youtube_box_noncename' );
        
        // show featured video if it exists
        echo $this->get_yotube_video( $post->ID, 260, 120);
        
        echo '<h4 style="margin: 10px 0 0 0;">URL [YouTube Only]</h4>';
        echo '<input type="text" id="youtube_videoURL_field" name="youtube_videoURL_field" value="'.get_post_meta($post->ID, 'youtube_videoURL', true).'" style="width: 100%;" />';
    }
    
    public function youtube_save_postdata( $post_id ) {
        
        // check autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;
            
            // check authorizations
            if ( !wp_verify_nonce( $_POST['youtube_box_noncename'], plugin_basename( __FILE__ ) ) )
                return;
                
                // update meta/custom field
                update_post_meta( $post_id, 'youtube_videoURL', $_POST['youtube_videoURL_field'] );
    }
    
    public function get_yotube_video($post_id, $width = 680, $height = 360) {
        $youtube_videourl = get_post_meta($post_id, 'youtube_videoURL', true);
        
        if(!empty($youtube_videourl)){
            preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtube_videourl, $youtube_match);
            
            if ($youtube_match[1])
                return '<iframe width="'.$width.'" height="'.$height.'" src="http://ww'.
                'w.youtube.com/embed/'.$youtube_match[1].'?rel=0&showinfo=0&cont'.
                'rols=0&autoplay=0&modestbranding=1" frameborder="0" allowfulls'.
                'creen ></iframe>';
                else
                    return null;
        }else{
            return null;
            
        }
       
    }
}