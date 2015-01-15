<?php
/*
Template Name: Contact
*/
?>
<?php get_header(); ?>

	<?php do_action('foundationPress_before_content'); ?>

	<?php while ( have_posts() ) : the_post(); ?>

<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		
	<section class="clearfix">
		<div class="row">
			<div class="medium-6 columns">
				<h1 class="text--bold">Let's work together!</h1>
				<span class="form__input">
					<?php the_content(); ?>	
				</span>
			</div>
			<div class="medium-6 columns">
				<?php if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( 1 ); }; ?>
			</div>
		</div>
	</section>
	
	<section class="clearfix l-gray-light">
		<div class="tile-panel">
			<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script><div style="overflow:hidden;height:500px;width:100%;"><div id="gmap_canvas" style="height:500px;width:800px;"></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style><a class="google-map-code" href="http://www.trivoo.net/gutscheine/fleurop/" id="get-map-data">trivoo</a></div><script type="text/javascript"> function init_map(){var myOptions = {zoom:17,center:new google.maps.LatLng(1.2982647,103.85118590000002),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(1.2982647, 103.85118590000002)});infowindow = new google.maps.InfoWindow({content:"<b>Awaken Group</b><br/>51 Waterloo St<br/> Singapore" });google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
		</div>
		<div class="tile-panel">
			<div class="row l-gray-light">
				<div class="large-10 large-offset-1 columns">
					<h3 class="post__sectiontitle">Getting to our office</h3>									
					We encourage using public transportation or taxis as parking nearby can be difficult to find.  The closest MRT station to our office is at Bras Basah, City Hall or Bugis.  					<br /><br />
					<h3 class="post__sectiontitle">Parking</h3>									
					The nearest parking location is located underground at NTUC from the Queen Street entrance. Walk outside on Queen Street past the Singapore Art Museum towards SAM at 8Q Square. When you see Oxford Hotel, turn left into the small street and walk past the wall of Graffiti. Walk into the white colonial building and come up to the 3rd floor. Make a right and our office is right there!
	 			</div>
			</div>
		</div>		
	</section>
	
	<?php endwhile; // end of the loop. ?>		

</article>
	
	<?php get_template_part('parts/careers'); ?>

	<?php do_action('foundationPress_after_content'); ?>

<?php get_footer(); ?>
