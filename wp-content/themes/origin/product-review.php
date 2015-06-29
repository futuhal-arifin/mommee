<?php
/**
 * Product Review Template
 *
 * This template is used to show your Product Review category post.
 * Added by Futuhal Arifin Annasri to meet the client request.
 *
 * @package Origin
 * @subpackage Template
 */
?>
<?php 
	$counter = 0;
	query_posts('cat=22');
	if ( have_posts() ) : ?>
	<div class="product-review">
		<h3>Product Review - <span><a href="<?php echo home_url() . "/category/product-review/";?>">View All</a></span></h3>
		<?php while (  $counter < 4 && have_posts() ) : the_post(); ?>
	
			 	<?php do_atomic( 'before_entry' ); // origin_before_entry ?>
	
					<div id="post-<?php the_ID(); ?>" class="product-review-item">
	
						<?php do_atomic( 'open_entry' ); // origin_open_entry ?>
	
						<?php if ( current_theme_supports( 'get-the-image' ) ) {
								$counter++;
								get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'thumbnail', 'image_class' => 'featured' ) );
							}
						?>
						<div class="hentry information">
							<div class="sticky-header">
									
								<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
									
							</div><!-- .sticky-header -->
							
							<div class="entry-summary">
								
								<?php the_excerpt(); ?>
								
								<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'origin' ), 'after' => '</p>' ) ); ?>
									
							</div><!-- .entry-summary -->
						</div>
	
						<?php do_atomic( 'close_entry' ); // origin_close_entry ?>
	
					</div><!-- .hentry -->
	
				<?php do_atomic( 'after_entry' ); // origin_after_entry ?>
			
		<?php endwhile; ?>

	</div>
<?php else : ?>

	<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

<?php endif; ?>