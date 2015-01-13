<?php
/*
Template Name: Contact
*/
?>
<?php get_header(); ?>

	<?php do_action('foundationPress_before_content'); ?>

	<?php while ( have_posts() ) : the_post(); ?>

<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		
	<section class="clearfix">
		<div class="row">
			<div class="medium-6 columns">
				<h1>We would love to work with your organization to achieve your goals while living out your purpose and values</h1>
			</div>
			<div class="medium-6 columns">
				<?php if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( 1 ); }; ?>
			</div>
		</div>
	</section>
	<?php endwhile; // end of the loop. ?>		

</article>
	
	<?php get_template_part('parts/cocreate'); ?>

	<?php do_action('foundationPress_after_content'); ?>

<?php get_footer(); ?>
