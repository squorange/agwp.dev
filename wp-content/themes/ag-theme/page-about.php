<?php
/*
Template Name: About
*/
?>
<?php get_header(); ?>

	<?php do_action('foundationPress_before_content'); ?>

	<?php while ( have_posts() ) : the_post(); ?>

<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		
	<header class="clearfix l-testimonial">
	  <div class="row row--header row--first">
	    <div class="large-12 columns header__text-title">
				<h1>Our clients look to us for<br /><span class="rotate text--bold">Change, Transformation, Innovation, Growth, Capabilities, Inspiration, Alignment, Leadership</span></h1>
				<br />
			</div>
		</div>
	</header>
	
	<section class="clearfix">
		<div class="row">
			<div class="small-12 medium-8 medium-offset-2 columns" role="main">
			<?php the_content(); ?>	
			</div>
		</div>
	</section>

	<section class="clearfix">
		<div class="row">
			<div class="small-12 medium-10 medium-offset-1 columns post__quote">
				<h2 class="post__subtitle">Our Vision</h2>
				<?php the_field('about_vision'); ?>				
			</div>
		</div>
	</section>
	
	<section class="clearfix">
		<div class="row clearfix">
			<div class="small-12 medium-10 medium-offset-1 columns">			
				<h2 class="post__subtitle text--center">Our 3-Part Mission</h2>
			</div>
		</div>
		<div class="row">
				<div class="small-12 medium-4 columns clearfix">
					<section>										
					<h3 class="post__sectiontitle text--center">Raise Consciousness</h3>				
					<?php the_field('mission_consciousness'); ?>			
					</section>						
				</div>
				<div class="small-12 medium-4 columns clearfix">
					<section>					
					<h3 class="post__sectiontitle text--center">Guide Through Change</h3>				
					<?php the_field('mission_change'); ?>				
					</section>
				</div>
				<div class="small-12 medium-4 columns clearfix">
					<section>
					<h3 class="post__sectiontitle text--center">Unleash Creativity</h3>								
					<?php the_field('mission_creativity'); ?>				
					</section>
				</div>
		</div>
	</section>
	
	<section class="clearfix">
		<div class="row row--header">
	    <div class="large-10 large-offset-1 columns">
				<h1>
					<?php the_field('about_funding'); ?>		
				</h1>
			</div>
		</div>
		<div class="row">
			<div class="large-6 large-offset-3 columns header__text-blurb">
				<?php the_field('about_funding_blurb'); ?>
			</div>
		</div>
		<div class="row">
			<div class="large-4 large-offset-4 medium-6 medium-offset-3 columns">
				<a href="#" class="button expand radius"><span class="text--bold">Learn</span> about funding</a>
			</div>
		</div>	
	</section>
	
	<section class="l-header-featured clearfix">
		<div class="header-featured">	
			<a href="<?php the_field('core_beliefs_video'); ?>" class="swipebox-video">
				<div class="header__image-wrap">
					<img src="<?php the_field('core_beliefs_screenshot'); ?>" />
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
	

	<?php endwhile; // end of the loop. ?>		

</article>
	
	<?php get_template_part('parts/cocreate'); ?>

	<?php do_action('foundationPress_after_content'); ?>

<?php get_footer(); ?>
