<?php get_header(); ?>
	<!-- Begin single-ag_share -->
	<?php do_action('foundationPress_before_content'); ?>

	<?php while (have_posts()) : the_post(); ?>
		
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header class="l-header-single-post">
				<a href="<?php the_field('video_url'); ?>"><img src="<?php the_field('header_image'); ?>" /></a>
			</header>
			<?php do_action('foundationPress_post_before_entry_content'); ?>
			
			<div class="row">
				<div class="small-12 medium-8 medium-offset-2 columns" role="main">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="post__meta">
						<?php the_time('F Y') ?><br />
						<?php echo __('Written by', 'FoundationPress') .' <a href="'. get_author_posts_url(get_the_author_meta('ID')) .'" rel="author" class="fn">'. get_the_author() .'</a>'; ?>
					</div>
					<?php the_content(); ?>
				</div>
			</div>

		</article>
	<?php endwhile;?>

	<?php do_action('foundationPress_after_content'); ?>


<?php get_footer(); ?>
