<?php
/*
Template Name: Basic
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

	<article>
		<section class="clearfix">			
			<div class="row">
				<div class="small-12 medium-8 medium-offset-2 columns" role="main">
					<?php the_content(); ?>
				</div>
			</div>
		</section>
	</article>

	<?php endwhile; // end of the loop. ?>
	
	<?php get_template_part('parts/cocreate'); ?>

	<?php do_action('foundationPress_after_content'); ?>

<?php get_footer(); ?>
