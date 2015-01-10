<?php get_header(); ?>
	<!-- Begin single-ag_share -->
	<?php do_action('foundationPress_before_content'); ?>

	<?php while (have_posts()) : the_post(); ?>
		
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			
			<section class="l-header-featured clearfix"> <!-- FEATURED POST -->
				<div class="header-featured">	
					<a href="<?php the_field('video_url'); ?>" class="swipebox-video">
						<div class="header__image-wrap">
							<img src="<?php the_field('header_image'); ?>" />
							<div class="header__label-wrap">
								<div class="header__label-inner">
									<div class="header__label">
										<img class="icon--play" src="<?php echo get_stylesheet_directory_uri() ; ?>/assets/img/icons/icon-play.png" />
							 		</div>
							 	</div>
							</div>						
						</div>
					</a>
				</div>
			</section>
						
			<?php do_action('foundationPress_post_before_entry_content'); ?>
			
			<section class="clearfix">
				<div class="row">
					<div class="small-12 medium-8 medium-offset-2 columns" role="main">
						<div class="post__title">
							<h1><?php the_title(); ?></h1>
							<div class="post__summary">
								<?php the_time('F Y') ?><br />
								<?php echo __('Written by', 'FoundationPress') .' <a href="'. get_author_posts_url(get_the_author_meta('ID')) .'" rel="author" class="fn">'. get_the_author() .'</a>'; ?>
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
