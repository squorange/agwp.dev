<?php
/*
Template Name: Front Page
*/
get_header(); ?>
  <div class="row row--header row--first">
    <div class="large-8 large-offset-2 columns">
			<h1>
			We are pioneers of <span class="text--bold">Transformation Design</span>&mdash;integrating strategy, leadership, and design to achieve sustainable outcomes for complex issues
			</h1>
		</div>
	</div>
	<div class="row">
		<div class="large-4 large-offset-4 medium-6 medium-offset-3 columns">
			<a href="#" class="button expand radius"><span class="text--bold">Co-Create</span> with us</a>
		</div>
	</div>	
	
<section class="clearfix"> <!-- BEGIN TILES -->
	<div id="Container" class="l-tiles container clearfix">
	
<?php
$queryObject = new WP_Query( 'post_type=ag_share&posts_per_page=8' );
// The Loop!
if ($queryObject->have_posts()) {
    ?>
    <?php
    while ($queryObject->have_posts()) {
        $queryObject->the_post();
        ?>

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

    <?php }} ?>
		
	</div>
</section> <!-- END TILES -->

	<?php get_template_part('parts/newsletter-signup'); ?>

<?php get_footer(); ?>
