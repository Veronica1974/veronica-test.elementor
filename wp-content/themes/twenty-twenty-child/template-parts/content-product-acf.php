<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Child
 * @since Twenty Twenty Child1.0
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	

	<div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">
<?php

	get_template_part( 'template-parts/entry-header' );


	?>
		<div class="entry-content">
		   <div class="thumbnail-single itembox flex flex-row">
		   <?php the_post_thumbnail('large');?>
		   </div>
			<?php
			
			$second_featured_forsale = get_post_meta($post->ID,'second_featured_forsale', true) ? 'in Sale' : 'not in Sale';
			$youtubeUrl = get_post_meta($post->ID,'youtube_videoURL', true);
			
			
			if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
				the_excerpt();
			} else {
				the_content( __( 'Continue reading', 'twentytwenty' ) );
			}
			//echo do_shortcode('[gallary_product_post id="'. $post->ID.'"]'); 
			//echo do_shortcode('[display_product_price id="'. $post->ID.'"]'); 
			echo apply_filters('the_product_content',$post->ID);
			?>
			
			
			<div class="itembox flex flex-row">
			<?php echo $second_featured_forsale;?>
			</div>
			<?php 
			if(!empty($youtubeUrl)){
			    $yutube_arr_arr = explode('=', $youtubeUrl);
			    ?>			    
        			 <div class="yutubebox flex flex-row">
        			<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $yutube_arr_arr[1];?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        			</iframe>
        			</div>
			
			<?php } ?>s

		</div><!-- .entry-content -->

	</div><!-- .post-inner -->

	
	<?php

	if ( is_single() ) {

		get_template_part( 'template-parts/navigation' );

	}

	/**
	 *  Output comments wrapper if it's a post, or if comments are open,
	 * or if there's a comment number – and check for password.
	 * */
	if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
		?>

		<div class="comments-wrapper section-inner">

			<?php comments_template(); ?>

		</div><!-- .comments-wrapper -->

		<?php
	}
	?>

</article><!-- .post -->
