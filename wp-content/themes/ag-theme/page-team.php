<?php
/*
Template Name: Team
*/
?>
<?php get_header(); ?>

	<?php do_action('foundationPress_before_content'); ?>

	<?php while ( have_posts() ) : the_post(); ?>

	<header class="clearfix l-yellow-short">
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
	</header>

  <section class="clearfix"> <!-- BEGIN TILES -->
		<div id="Container" class="l-tiles container clearfix">

				<?php
				$args = array(
					'post_type' => 'ag_team',
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
									<div class="tile__label-name">
										<?php the_title(); ?><br />
										<?php the_field('team_member_title'); ?>
									</div>
									<div class="tile__label-caption">
										<?php the_field('team_member_summary'); ?>
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
	
  <section class="clearfix l-gray-light">
		<div class="row">
			<div class="medium-8 medium-offset-2 columns">
				<h2 class="post__subtitle text--center">Creative Collaborative</h2>
				<?php the_field('creative_collaborative'); ?>
			</div>
		</div>		
	</section>	
	
	
	<?php endwhile; // end of the loop. ?>
	
	<?php get_template_part('parts/cocreate'); ?>

	<?php do_action('foundationPress_after_content'); ?>

<?php get_footer(); ?>
