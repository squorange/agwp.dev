<?php
global $wpdb;
global $stats;

$mode = isset ( $_GET ["mode"] ) ? $_GET ["mode"] : "1";
$month = isset ( $_GET ['essb_month'] ) ? $_GET ['essb_month'] : '';

$today = date ( 'Y-m-d' );
$today_month = date ( 'Y-m' );

$essb_date_to = "";
$essb_date_from = "";

if ($essb_date_to == '') {
	$essb_date_to = date ( "Y-m-d" );
}

if ($essb_date_from == '') {
	$essb_date_from = date ( "Y-m-d", strtotime ( date ( "Y-m-d", strtotime ( date ( "Y-m-d" ) ) ) . "-1 month" ) );
}

$ovarall_stats = $stats->essb_stats_by_networks ();
$options = get_option ( EasySocialShareButtons::$plugin_settings_name );

$essb_networks = $options ['networks'];

$calculated_total = 0;
$networks_with_data = array ();
if (isset ( $ovarall_stats )) {
	$cnt = 0;
	foreach ( $essb_networks as $k => $v ) {
		
		$calculated_total += intval ( $ovarall_stats->{$k} );
		
		if (intval ( $ovarall_stats->{$k} ) != 0) {
			$networks_with_data [$k] = $k;
		}
	}
}

// print $essb_date_to;
if ($mode == "1") {
	$sqlObject = $stats->getDateRangeRecords ( $essb_date_from, $essb_date_to );
	// print_r($sqlObject);
	$dataPeriodObject = $stats->sqlDateRangeRecordConvert ( $essb_date_from, $essb_date_to, $sqlObject );
	
	$sqlMonthsData = $stats->essb_stats_by_networks_by_months ();
}

// print_r($dataPeriodObject);
?>

<?php if ($mode == "1") { ?>
<div class="wrap">
	<div class="essb-dashboard">
		<div class="essb-dashboard-panel">
			<div class="essb-dashboard-panel-title">
				<h4>Overall social share stats since function is activated</h4>
			</div>
			<div class="essb-dashboard-panel-content">

				<div class="row">

					<div class="onethird">
						<div class="big-panel blue1">
							<div class="number"><?php echo $stats->prettyPrintNumber($calculated_total); ?></div>
							<div class="text">Total Shares on social networks for the entire
								period</div>
						</div>
					</div>
					<div class="twothird">

						<?php
	
	if (isset ( $ovarall_stats )) {
		$cnt = 0;
		foreach ( $essb_networks as $k => $v ) {
			
			$single = intval ( $ovarall_stats->{$k} );
			
			if ($single > 0) {
				?>
									<div class="small-panel grey1">
							<div class="number"><?php echo $stats->prettyPrintNumber($single); ?></div>
							<div class="text"><?php echo $v[1]; ?></div>
						</div>
									<?php
			}
		}
	}
	
	?>
					
						
					</div>

				</div>

			</div>

		</div>

		<div class="clear"></div>

		<div class="essb-dashboard-panel">
			<div class="essb-dashboard-panel-title">
				<h4>Social activity for the last 30 days</h4>
			</div>
			<div class="essb-dashboard-panel-content" id="essb-changes-graph"
				style="height: 300px;"></div>
		</div>

		<div class="clear"></div>

		<div class="essb-dashboard-panel">
			<div class="essb-dashboard-panel-title">
				<h4>Social activity by months</h4>
				
			</div>
			<div class="essb-dashboard-panel-content">
			<?php $stats->essb_stat_admin_detail_by_month ($sqlMonthsData, $networks_with_data); ?>
			</div>
		</div>
		
		<div class="clear"></div>

		<div class="essb-dashboard-panel">
			<div class="essb-dashboard-panel-title">
				<h4>Leading posts in social actions</h4>
				<button class="button-primary"
					style="float: right; margin-top: -22px;"
					onclick="window.location='admin.php?page=essb_settings&tab=stats&mode=3';">Full
					content report</button>
			</div>
			<div class="essb-dashboard-panel-content">
			<?php $stats->essb_stat_admin_detail_by_post ('', $networks_with_data, 20); ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<?php if ($mode == "2") { ?>
<div class="wrap">
	<div class="essb-dashboard">



		
		<?php if ($month != '') { ?>
		<div class="essb-dashboard-panel">
			<div class="essb-dashboard-panel-title">
				<h4>Activity by date of month</h4>
			</div>
			<div class="essb-dashboard-panel-content">
			<?php $stats->generate_bar_graph_month($month, $networks_with_data);?>
			</div>
		</div>

		<div class="essb-dashboard-panel">
			<div class="essb-dashboard-panel-title">
				<h4>Content details for this month</h4>
			</div>
			<div class="essb-dashboard-panel-content">
			<?php $stats->essb_stat_admin_detail_by_post( $month, $networks_with_data );?>
			</div>
		</div>
	
			
		
		<?php } ?>
		

	</div>
</div>
<?php } ?>

<?php if ($mode == "3") { ?>
<div class="wrap">
	<div class="essb-dashboard">

		<div class="essb-dashboard-panel">
			<div class="essb-dashboard-panel-title">
				<h4>Full social activity content report</h4>
			</div>
			<div class="essb-dashboard-panel-content">
			<?php $stats->essb_stat_admin_detail_by_post( '', $networks_with_data );?>
			</div>
		</div>





	</div>
</div>
<?php } ?>
<script type="text/javascript">
jQuery(document).ready(function($){
      <?php
						if ($mode == "1" || $mode == '2') {
							echo $stats->keyObjectToMorrisLineGraph ( 'essb-changes-graph', $dataPeriodObject, 'Social activity' );
						}
						?>
});
	
</script>