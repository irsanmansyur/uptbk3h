<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Greed
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="latest-content">
	<header class="header-content">
			<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
		<div class="title-meta"> 
			<?php if ( 'post' == get_post_type() ) : ?>
				<?php greed_top_meta();?>
			<?php endif; ?>
		</div>
			<br class="clear">
	</header><!-- .entry-header -->

	<div class="entry-summary">    
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php if ( 'post' == get_post_type() ): ?>
		<footer class="entry-footer">     
			<?php greed_entry_footer(); ?>   
		</footer><!-- .entry-footer -->
	<?php endif;?>
</div>

</article><!-- #post-## -->
