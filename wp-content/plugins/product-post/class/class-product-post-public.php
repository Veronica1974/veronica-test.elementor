<?php


class Product_Post_Public
{
    
    private  $plugin_name ;
   
    private  $version ;
   
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    
    public function enqueue_styles()
    {
        
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/product-post-public.css',
            array(),
            $this->version,
            'all'
        );
    }
    
   
    public function enqueue_scripts()
    {
       
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'js/product-post-public.js',
            array( 'jquery' ),
            $this->version,
            false
        );
    }
    
    public function gallary_per_post($atts){
        global $post;
        $rg = (object) shortcode_atts( [
            'id' => null
        ], $atts );
        
        $post = get_post( $rg->id );    
        $guid_arr = array();
        $html = '';
        $second_featured_img = get_post_meta($post->ID,'second_featured_img', true);
        $second_featured_img_arr = explode(',', $second_featured_img);
        $img_count = count($second_featured_img_arr);
        $html .= '<div class="itembox flex flex-row">';       
        $html .= '<div class = "gallary-grid-container">';
       
        for($i=0; $i<$img_count; $i++){
			   $html .=	'<div class="gallary-item">';
			   $html .= '<img alt="" src="'.wp_get_attachment_url($second_featured_img_arr[$i] ).'">';
			   $html .=	'</div>';
			    
		}
			
		$html .= '</div></div>';
		wp_reset_postdata();
		return $html;
        
    }
    
    public function display_main_title($atts){
        global $post;
        
        $rg = (object) shortcode_atts( [
            'id' => null,
            'sinular'=>'',
        ], $atts );
        $post = get_post( $rg->id );    
        if(!empty($atts['sinular'])){
            $title = '<h1 class="entry-title">'.$post->post_title. '</h1>';
            
        }else{
            $title = '<h2 class="entry-title heading-size-1"><a href="' . esc_url( get_permalink($post->ID) ) . '">'. $post->post_title . '</a></h2>';
        }
        
        wp_reset_postdata();
        return wp_specialchars($title);
    }
    
    public function display_product_price($atts){
        global $post;
        $rg = (object) shortcode_atts( [
            'id' => null
        ], $atts );
        
        $post = get_post( $rg->id );   
        $html = '';
        $product_custom_price = get_post_meta($post->ID,'product_custom_price', true);
        
        $html .= '<div class="itembox flex flex-row">Product price: '. $product_custom_price.'</div>';
        wp_reset_postdata();
        return $html;
    }
       
   
}