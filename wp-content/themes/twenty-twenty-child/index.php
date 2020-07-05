<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Child
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content" role="main" class="grid-container">

	<?php

	$archive_title    = '';
	$archive_subtitle = '';
	$loop = new WP_Query( array( 'post_type' => 'product_acf', 'posts_per_page' => 10 ) ); 
   
   while ( $loop->have_posts() ) : $loop->the_post(); 
   
   ?>
   <div class="box">
    <div class="list-title">
        <?php the_title( '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a>' ); ?>   
    </div>
     <div class="entry-content">
            <?php 
            the_post_thumbnail('medium');
            the_content(); ?>
     </div>
</div>
 <?php   
 endwhile; 

	

	
	?>

	<?php get_template_part( 'template-parts/pagination' ); ?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
