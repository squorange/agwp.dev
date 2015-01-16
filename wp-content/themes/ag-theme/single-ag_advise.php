<?php get_header(); ?>
	<!-- Begin single-ag_advise -->
	<?php do_action('foundationPress_before_content'); ?>

	<?php while (have_posts()) : the_post(); ?>
		
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header class="l-header-single-post">
				<a href="<?php the_field('video_url'); ?>"><img src="<?php the_field('header_image'); ?>" /></a>
			</header>

			<?php do_action('foundationPress_post_before_entry_content'); ?>

			<section class="clearfix">			
				
				<div class="row">
					<div class="small-12 medium-8 medium-offset-2 columns" role="main">
						<div class="post__title">
							<h1><?php the_title(); ?></h1>
						</div>
						<?php the_content(); ?>					
					</div>
				</div>

				<div class="row">
					<div class="small-12 medium-8 medium-offset-2 columns">
						<h2 class="post__subtitle">The Story</h2>
						<?php the_field('project_story'); ?>
						<br /><br />
					</div>
				</div>
			
			</section>

			<section class="l-gray-light text--center">
				<div class="row">
					<div class="small-12 medium-10 medium-offset-1 columns">
						<h2 class="post__subtitle">Design Challenge</h2>
						<h1>
							<?php the_field('project_challenge'); ?>
						</h1>
					</div>
				</div>		
			</section>			

			<section class="clearfix">
				
				<div class="row">
					<div class="small-12 medium-8 medium-offset-2 columns">
						<h2 class="post__subtitle">Objectives</h2>
						<?php the_field('project_objectives'); ?>
					</div>
				</div>				

				<div class="row">
					<div class="small-12 medium-8 medium-offset-2 columns">
						<h2 class="post__subtitle">Objectives</h2>
						<?php the_field('project_objectives'); ?>
					</div>
				</div>

				<div class="row">
					<div class="small-12 medium-8 medium-offset-2 columns">
						<h2 class="post__subtitle">Approach</h2>
						<?php the_field('project_approach'); ?>
					</div>
				</div>

				<div class="row">
					<div class="small-12 medium-8 medium-offset-2 columns">
						<h2 class="post__subtitle">Impact</h2>
						<?php the_field('project_impact'); ?>
					</div>
				</div>
				
			</section>
		
			<section class="clearfix l-gray-light">
				<div class="row">
					<div class="small-12 medium-8 medium-offset-2 columns">
						<?php the_field('project_testimonials'); ?>
					</div>
				</div>
			</section>
		
		</article>
	<?php endwhile;?>

	<?php do_action('foundationPress_after_content'); ?>

	<?php get_template_part('parts/cocreate'); ?>

<?php get_footer(); ?>
