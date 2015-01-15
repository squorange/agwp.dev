<footer>
	<?php do_action('foundationPress_before_footer'); ?>

		<div class="row">
				<div class="small-6 large-3 columns">
					<div class="footer__locations">
						<span class="text--bold">Singapore</span><br />
						51 Waterloo St #03-06<br />
						Singapore 187969<br />
						<br />
						<span class="text--bold">USA</span><br />
						445 S Figueroa #2600<br />
						Los Angeles CA 90071<br />
					</div>
				</div>
				<div class="small-6 large-3 columns">
					<div class="footer__links">
						<a href="<?php echo home_url(); ?>/about/">About Us</a><br />
						<a href="<?php echo home_url(); ?>/contact/">Contact Us</a><br />
						<a href="<?php echo home_url(); ?>/funding/">Government Funding</a><br />
						<br />
						<a href="<?php echo home_url(); ?>/terms/">Terms of Use</a><br />
						<a href="<?php echo home_url(); ?>/privacy/">Privacy</a>
					</div>
				</div>	
				<div class="small-12 large-6 columns">
				<div class="footer__contact-wrap">
					<div class="footer__contact">
						<a class="link--contact" href="mailto:contact@awakengroup.com">contact@awakengroup.com</a><br />
						<br />
						<a href="https://www.facebook.com/awakengroup">facebook</a> / 
						<a href="https://twitter.com/awakengroup">twitter</a> / 
						<a href="https://www.linkedin.com/company/awaken-group">linkedin</a>
					</div>
				</div>
			</div>			
		</div>
		
		
		<div class="row">
			<div class="large-12 columns">
				&copy; 2014 Awaken Group. All rights reserved.
			</div>
		</div>

	<?php do_action('foundationPress_after_footer'); ?>
</footer>
<a class="exit-off-canvas"></a>

	<?php do_action('foundationPress_layout_end'); ?>
	</div>
</div>

<?php wp_footer(); ?>
<?php do_action('foundationPress_before_closing_body'); ?>
</body>
</html>
