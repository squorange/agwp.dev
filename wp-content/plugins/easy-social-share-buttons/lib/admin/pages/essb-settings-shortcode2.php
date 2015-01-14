<?php

$active_shortcode = isset($_REQUEST['code']) ? $_REQUEST['code'] : 'easy-social-share';


$scg = new ESSBShortcodeGenerator();
$scg->activate($active_shortcode);

?>


<div class="wrap">

		<div class="essb-shortcode-container essb-shortcode-select">
			<div class="essb-shortcode-title">Choose shortcode</div>
			<a href="<?php echo add_query_arg ( 'code', 'easy-social-share', 'admin.php?page=essb_settings&tab=shortcode2' );?>" class="essb-shortcode essb-shortcode-fixed">[easy-social-share]<br/><span class="essb-shortcode-comment">Shortcode to display social share buttons</span></a>
			<a href="<?php echo add_query_arg ( 'code', 'easy-social-like', 'admin.php?page=essb_settings&tab=shortcode2' );?>" class="essb-shortcode essb-shortcode-fixed">[easy-social-like]<br/><span class="essb-shortcode-comment">Shortcode to display native social buttons</span></a>
			<a href="<?php echo add_query_arg ( 'code', 'easy-total-shares', 'admin.php?page=essb_settings&tab=shortcode2' );?>" class="essb-shortcode essb-shortcode-fixed">[easy-total-shares]<br/><span class="essb-shortcode-comment">Shortcode to display total shares</span></a>
			<a href="<?php echo add_query_arg ( 'code', 'easy-share', 'admin.php?page=essb_settings&tab=shortcode' );?>" class="essb-shortcode essb-shortcode-fixed">[easy-share]<br/><span class="essb-shortcode-comment">Version 1.x general shortcode</span></a>			
		</div>

		<?php 
		
		$cmd = isset($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';
		
		if ($cmd == 'generate') {
			$options = isset($_REQUEST[$scg->optionsGroup]) ? $_REQUEST[$scg->optionsGroup]: array();
			
			echo '<div class="essb-shortcode-container">';
			
			$scg->generate($options);
			
			echo '</div>';
		}
		
		?>
	
		<form name="general_form" method="post"
		action="admin.php?page=essb_settings&tab=shortcode2">
		<input type="hidden" id="cmd" name="cmd" value="generate" />
		<input type="hidden" id="code" name="code" value="<?php echo $active_shortcode; ?>"/>
 			<?php wp_nonce_field('essb'); ?>
			<div class="essb-options">
			<div class="essb-options-header" id="essb-options-header">
				<div class="essb-options-title">
					Shortcode Generator<br />
					<span class="label" style="font-weight: 400;"><a
						href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref=appscreo"
						target="_blank" style="text-decoration: none;">Easy Social Share Buttons for WordPress version <?php echo ESSB_VERSION; ?></a></span>
				</div>		
<?php echo '<a href="http://support.creoworx.com" target="_blank" text="' . __ ( 'Need Help? Click here to visit our support center', ESSB_TEXT_DOMAIN ) . '" class="button">' . __ ( 'Support Center', ESSB_TEXT_DOMAIN ) . '</a>'; ?>		
		<?php echo '<input type="Submit" name="Submit" value="' . __ ( 'Generate Shortcode', ESSB_TEXT_DOMAIN ) . '" class="button-primary" />'; ?>
	</div>
			<div class="essb-options-sidebar">
				<ul class="essb-options-group-menu">
					<?php 
					$scg->renderNavigation();
					?>
				</ul>
			</div>
			<div class="essb-options-container">
				<div id="essb-container-1" class="essb-data-container">

				<?php 
				
				$scg->render();
				
				?>

				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">

jQuery(document).ready(function(){
    essb_option_activate('1');
    jQuery('.essb-options-header').scrollToFixed( { marginTop: 30 } );
});

</script>