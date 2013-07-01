<?php
/**
 * The template for displaying the footer.
 *
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */
?>
			<?php do_action( 'wwl_close_main' ); // Hook ?>
		</div> <!-- #main -->
		<?php do_action( 'wwl_after_main' ); // Hook ?>
		<?php do_action( 'wwl_before_footer' ); // Hook ?>
		<footer id="footer" role="contentinfo">
			<?php do_action( 'wwl_footer' ); // Hook ?>
			<div id="footer-content">
				<div class="container">
					<?php  echo do_shortcode('<div id="copyright">[footer_copyright]</div> <div id="credit">Powered by [footer_wordpress_link]. Design by [footer_wildweblab_link]</div>'); ?>
					<div class="clearfix"></div>
				</div>
			</div>
		</footer>
		<?php do_action( 'wwl_after_footer' ); // Hook ?>
	</div> <!-- #wrap -->
	<?php do_action( 'wwl_after_wrap' ); // Hook ?>
	<?php wp_footer(); ?>
	</body>
</html>