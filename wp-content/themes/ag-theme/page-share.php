<?php
/*
Template Name: Share
*/
?>
<?php get_header(); ?>

	<?php do_action('foundationPress_before_content'); ?>

<form class="controls" id="Filters">
  <!-- We can add an unlimited number of "filter groups" using the following format: -->
  
  <fieldset>
    <h4>Topics</h4>
    <select>
      <option value="">All Transformation Design</option>
      <option value=".share__leadership-strategy">Leadership &amp; Strategy</option>
      <option value=".share__culture-values">Culture &amp; Values</option>
      <option value=".share__design-brand">Design &amp; Brand</option>
      <option value=".share__innovation-trends">Innovation &amp; Trends</option>
    </select>
  </fieldset>
  
	
	<div class="filter" data-filter="all">Show All</div>
	<div class="filter" data-filter=".share__leadership-strategy">Leadership &amp; Strategy</div>
	<div class="filter" data-filter=".share__culture-values">Culture &amp; Values</div>
	<div class="filter" data-filter=".share__design-brand">Design &amp; Brand</div>
	<div class="filter" data-filter=".share__innovation-trends">Innovation &amp; Trends</div>	
	<br />
	<div class="sort" data-sort="default">Default</div>
	<div class="sort" data-sort="myorder:asc">Ascending</div>
	<div class="sort" data-sort="myorder:desc">Descending</div>
	
  <button id="Reset">Clear Filters</button>
</form>

  <section class="clearfix"> <!-- BEGIN TILES -->
		<div id="Container" class="l-tiles container">

				<?php
				$args = array(
					'post_type' => 'ag_share',
					'nopaging' => true
				);
		
				$the_query = new WP_Query( $args );
						
				while ( $the_query->have_posts() ) : $i++;
				$the_query->the_post(); ?>

				<div class="tile-single mix <?php echo implode(" ", get_field('topic')); ?>" data-myorder="<?php echo $i ?>" >
					<a href="<?php the_permalink(); ?>">
						<div class="tile__image-wrap">
							<?php the_post_thumbnail('-tile'); ?>
							<div class="tile__label-wrap">
								<div class="tile__label-inner">
									<div class="tile__label-title">
										<?php the_title(); ?>
									</div>
									<div class="tile__label-caption">
										<?php echo get_the_excerpt(); ?>
									</div>
								</div><!-- end .tile__label-inner -->
							</div><!-- end .tile__label-wrap -->
						</div><!-- end .tile__image-wrap -->
					</a>
				</div>
		
				<?php endwhile; wp_reset_postdata(); ?>	

			  <div class="gap"></div>
			  <div class="gap"></div>
			  <div class="gap"></div>
			  <div class="gap"></div>

		</div>
	</section> <!-- END TILES -->
	

	<?php do_action('foundationPress_after_content'); ?>


<?php get_footer(); ?>
