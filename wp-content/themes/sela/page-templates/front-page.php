<?php
/**
 * Template Name: Front Page
 *
 * @package Sela
 */

get_header(); ?>
	<div class="content-wrapper <?php echo sela_additional_class(); ?>">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<?php echo do_shortcode("[huge_it_slider id='1']"); ?>
				<div class="child-pages grid">
					<?php
						$args = array( 'posts_per_page' => 5, 'offset'=> 0);
						
						$myposts = get_posts( $args );
						foreach ( $myposts as $post ) : setup_postdata( $post ); 
							get_template_part( 'content', 'grid' );
					?>
					<?php endforeach; 
						wp_reset_postdata();?>


				</div><!-- .child-pages .grid -->

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>
	</div><!-- .content-wrapper -->

<?php get_footer(); ?>