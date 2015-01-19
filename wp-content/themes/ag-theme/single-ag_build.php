<?php get_header(); ?>
	<!-- Begin single-ag_build -->
	<?php do_action('foundationPress_before_content'); ?>

	<?php while (have_posts()) : the_post(); ?>
		
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header class="l-header-single-post">
				<img src="<?php the_field('header_image'); ?>" />
			</header>
			<?php do_action('foundationPress_post_before_entry_content'); ?>

			<section class="clearfix">			
				<div class="row">
					<div class="small-12 medium-8 medium-offset-2 columns" role="main">
						<div class="post__title">
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<div class="post__summary">
								<?php the_field('project_summary'); ?>
							</div>
						</div>
						<?php the_content(); ?>
					</div>
				</div>
			</section>
			
		</article>
	<?php endwhile;?>

	<?php do_action('foundationPress_after_content'); ?>


<?php get_footer(); ?>
