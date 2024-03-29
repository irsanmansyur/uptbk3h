<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Greed
 */
?>
		</div> <!-- .container -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
	<?php 
		$footer_widgets = get_theme_mod( 'footer_widgets',true );
		if( $footer_widgets && ( is_active_sidebar('footer') ||is_active_sidebar('footer-2') ||is_active_sidebar('footer-3') ) ) : ?>
		<div class="footer-widgets">
			<div class="container">
				<?php get_template_part('footer','widgets'); ?>
			</div>
		</div>
	<?php endif; ?>
		<div class="site-info">
			<div class="container">
				<div class="copyright sixteen columns">   
				<?php if( get_theme_mod('copyright') ) : ?>
							<p><?php echo greed_footer_copyright(get_theme_mod('copyright')); ?></p>
						<?php else : 
								printf( __('<p>Powered by <a href="%1$s" target="_blank">Dinas Peternakan Makassar</a>', 'greed'), esc_url( 'http://wordpress.org/') );
								printf( '<span class="sep"> .</span>' );
								printf( __( 'Theme: Greed by <a href="%1$s" target="_blank" rel="designer">Webulous Themes</a></p>', 'greed' ), esc_url('http://www.webulousthemes.com/') );
					 endif;  ?>
				</div>
			</div>
		</div><!-- .site-info -->
		<?php if( get_theme_mod('scroll_to_top') ) : ?>
			<div class="scroll-to-top"><i class="fa fa-angle-up"></i></div><!-- .scroll-to-top -->
		<?php endif;  ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
