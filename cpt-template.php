<?php
/*
Template Name: CPT Template
*/

/*----------------------------------------------------------------------------------------------------
 * IMPORTANT: This is a template example that goes to the main directory of your theme. 
 * Create a page same as the slug value(plugin.php) and apply this template to show your cpt posts. 
 * Customize it as you like
 ----------------------------------------------------------------------------------------------------*/ 
 
 /**
 * Custom Body Class
 * @param array $classes
 * @return array
 */
function cpt_body_class( $classes ) 
{
  $classes[] = 'cpt-page';
  
  return $classes;
}

add_filter( 'body_class', 'cpt_body_class' );
?>

<?php get_header(); ?>

<?php query_posts('post_type=cpt_post&post_status=publish&posts_per_page=-1&orderby=menu_order&order=ASC'); ?>

<?php if( have_posts() ): ?>

	<?php while( have_posts() ): the_post(); ?>
	
	<article id="cpt-post-<?php get_the_ID(); ?>" <?php post_class(); ?>>
		<?php
		
		//Get thumbnail
		if( has_post_thumbnail() ) 
		{
			$thumb = get_the_post_thumbnail( $post->ID, 'cpt-thumbnail' );
			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id,'large', true);
			$large = $image_url[0];
			
			//Featured image
			printf('<a rel="link-%s" class="cpt-image" href="%s">%s</a>', $post->ID, $large, $thumb );
		}
	    
	    //Content html
	    printf('<a href="'.get_permalink().'" class="cpt-entry">%s%s</a>', the_title('<h2>', '</h2>', FALSE), apply_filters('the_content', get_the_content() ) );
	    ?>
	</article><!-- post -->
	
	<?php endwhile; ?>

<?php else: ?>

	<p>We couldn't find any posts.</p>

<?php endif;/*For posts*/ ?>

<?php
	//Reset Query - important
	wp_reset_query(); 
?>

<?php get_footer(); ?>