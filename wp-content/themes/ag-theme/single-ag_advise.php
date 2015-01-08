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
					<h1 class="entry-title"><?php the_title(); ?></h1>					
					<?php the_content(); ?>					
				</div>
			</div>
		</section>
			
		<section class="clearfix">
			<div class="row">
				<div class="large-12 columns">
					<h1 class="entry-title"><?php the_field('project_design_challenge'); ?></h1>					
				</div>
			</div>
		</section>
		
			<div class="row">
					The Approach

			</div>

		</article>
	<?php endwhile;?>

	<?php do_action('foundationPress_after_content'); ?>

	<?php get_template_part('parts/cocreate'); ?>

<?php get_footer(); ?>
