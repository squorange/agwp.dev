<?php
/*
Template Name: Share
*/
?>
<?php get_header(); ?>

	<?php do_action('foundationPress_before_content'); ?>

<!--
	<?php if(function_exists('iinclude_page')) iinclude_page(share_featured); ?>			
-->

<div class="l-filters">	
	
	<button class="filter" data-filter="all">All Transformation Design</button>
	<button class="filter" data-filter=".share__leadership-strategy">Leadership &amp; Strategy</button>
	<button class="filter" data-filter=".share__culture-values">Culture &amp; Values</button>
	<button class="filter" data-filter=".share__design-brand">Design &amp; Brand</button>
	<button class="filter" data-filter=".share__innovation-trends">Innovation &amp; Trends</button>	

<!--
	<button class="sort" data-sort="default">Default</button>
	<button class="sort" data-sort="myorder:asc">Ascending</button>
	<button class="sort" data-sort="myorder:desc">Descending</button>
-->
		
</div>

  <section class="clearfix"> <!-- BEGIN TILES -->
		<div id="Container" class="l-tiles container clearfix">

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
	
	<?php get_template_part('parts/newsletter-signup'); ?>

	<?php do_action('foundationPress_after_content'); ?>

<?php get_footer(); ?>
