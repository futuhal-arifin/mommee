<?php
/**
 * Secondary Menu Template
 *
 * Displays the Secondary Menu if it has active menu items.
 *
 * @package Origin
 * @subpackage Template
 * @author Futuhal Arifin A
 */

if ( has_nav_menu( 'secondary' ) ) : ?>

	<?php do_atomic( 'before_menu_primary' ); // origin_before_menu_primary ?>

	<div id="menu-secondary" class="article-navigation menu-container" role="navigation">

		<span class="menu-article-toggle"><?php _e( 'Articles', 'origin' ); ?></span>

		<?php do_atomic( 'open_menu_primary' ); // origin_open_menu_primary ?>

		<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container_class' => 'menu', 'menu_class' => 'nav-article-menu', 'menu_id' => 'menu-secondary-items', 'fallback_cb' => '' ) ); ?>

		<?php do_atomic( 'close_menu_primary' ); // origin_close_menu_primary ?>

	</div><!-- #menu-primary .menu-container -->

	<?php do_atomic( 'after_menu_primary' ); // origin_after_menu_primary ?>

<?php endif; ?>

