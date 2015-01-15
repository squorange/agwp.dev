<?php
/*
Template Name: Front Page
*/
get_header(); ?>


	<?php while ( have_posts() ) : the_post(); ?>

	<header class="clearfix l-yellow-short">
		<div class="row row--header row--first">
		  <div class="large-8 large-offset-2 columns">
				<h1><?php the_field('header_statement'); ?></h1>
			</div>
		</div>
		<div class="row">
			<div class="large-4 large-offset-4 medium-6 medium-offset-3 columns">
				<a href="<?php echo home_url(); ?>/about/" class="button expand radius text--bold"><?php the_field('header_blurb'); ?></a>
			</div>
		</div>
	</header>
	
	<?php endwhile; // end of the loop. ?>
	
<section class="clearfix"> <!-- BEGIN TILES -->
	<div id="Container" class="l-tiles container clearfix">
	
<?php
$queryObject = new WP_Query( 'post_type=ag_share&posts_per_page=7' );
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
		
		<div class="tile-single">
			<a href="<?php echo home_url(); ?>/share/">
				<div class="tile__image-wrap">
					<img class="tile__image attachment--tile" src="<?php echo get_stylesheet_directory_uri() ; ?>/images/tile-blank.png" />
					<div class="tile__label-wrap">
						<div class="tile__label-inner">
							<div class="tile__label-title">
								Read More
							</div>
							<div class="tile__label-caption">
								Explore more Transformation Design articles
							</div>							
						</div>
					</div>
				</div>
			</a>
		</div>
		
	</div>
</section> <!-- END TILES -->

<?php get_template_part('parts/newsletter-signup'); ?>

<?php get_footer(); ?>
