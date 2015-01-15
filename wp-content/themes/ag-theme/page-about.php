<?php
/*
Template Name: About
*/
?>
<?php get_header(); ?>

	<?php do_action('foundationPress_before_content'); ?>

	<?php while ( have_posts() ) : the_post(); ?>

<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		
	<header class="clearfix l-yellow-tall">
	  <div class="row row--header row--first">
	    <div class="large-12 columns header__text-title">
				<h1>Our clients look to us for<br /><span class="rotate text--bold">Change, Transformation, Innovation, Growth, Capabilities, Inspiration, Alignment, Leadership</span></h1>
				<br />
			</div>
		</div>
	</header>
	
	<section class="clearfix section--airspace">
		<div class="row">
			<div class="small-12 medium-8 medium-offset-2 columns" role="main">
			<?php the_content(); ?>	
			</div>
		</div>
	</section>

	<section class="clearfix section--cushion">
		<div class="row">
			<div class="small-12 medium-10 medium-offset-1 columns post__quote">
				<h2 class="post__subtitle">Our Vision</h2>
				<?php the_field('about_vision'); ?>				
			</div>
		</div>
	</section>
	
	<section class="clearfix l-subsection section--airtight">
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
	
	<?php get_template_part('parts/funding'); ?>
	
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

  <section class="clearfix section--airtight"> <!-- BEGIN TILES -->
		<div id="Container" class="l-tiles container clearfix">
			
			<div class="tile-single-wide">
				<a href="#">
					<div class="tile__image-wrap">
						<img class="tile__image attachment--tile" src="<?php echo get_stylesheet_directory_uri() ; ?>/images/tile-values-blank.jpg" />
						<div class="tile__label-wrap">
							<div class="tile__label-inner">
								<div class="tile__label-title-alt text--bold">
									Our Values
								</div>
								<div class="tile__label-caption">
									Our core beliefs define who we are and our approach in how we serve our clients
								</div>							
							</div>
						</div>
					</div>
				</a>
			</div>

			<?php
			$args = array(
				'post_type' => 'ag_values',
				'nopaging' => true
			);
	
			$the_query = new WP_Query( $args );
					
			while ( $the_query->have_posts() ) : $i++;
			$the_query->the_post(); ?>

			<div class="tile-single-wide mix" data-myorder="<?php echo $i ?>" >
				<a href="<?php the_permalink(); ?>">
					<div class="tile__image-wrap">
						<?php the_post_thumbnail('-tile'); ?>
						<div class="tile__label-wrap">
							<div class="tile__label-inner">
								<div class="tile__label-title-alt">
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

		</div>
	</section> <!-- END TILES -->
	

	<?php endwhile; // end of the loop. ?>		

</article>
	
	<?php get_template_part('parts/cocreate'); ?>

	<?php do_action('foundationPress_after_content'); ?>

<?php get_footer(); ?>
