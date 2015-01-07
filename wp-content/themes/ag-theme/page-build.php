<?php
/*
Template Name: Build
*/
?>
<?php get_header(); ?>

	<?php do_action('foundationPress_before_content'); ?>

	<?php while ( have_posts() ) : the_post(); ?>

  <div class="row row--header row--first">
    <div class="large-12 columns header__text-title">
			<h1><?php the_field('header_statement'); ?></h1>
		</div>
	</div>
	<div class="row">
		<div class="large-6 large-offset-3 columns header__text-blurb">
			<?php the_field('header_blurb'); ?>
		</div>
	</div>

	<?php endwhile; // end of the loop. ?>

  <section class="clearfix"> <!-- BEGIN TILES -->
		<div id="Container" class="l-tiles container clearfix">

				<?php
				$args = array(
					'post_type' => 'ag_build',
					'nopaging' => true
				);
		
				$the_query = new WP_Query( $args );
						
				while ( $the_query->have_posts() ) : $i++;
				$the_query->the_post(); ?>

				<div class="tile-single mix <?php echo implode(" ", get_field('project_type')); ?>" data-myorder="<?php echo $i ?>" >
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
	
	<?php get_template_part('parts/cocreate'); ?>

	<?php do_action('foundationPress_after_content'); ?>

<?php get_footer(); ?>
