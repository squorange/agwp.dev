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
			<div class="medium-6 columns l-contact">
				<h1 class="text--bold"><?php the_field('header_statement'); ?></h1>
				<span class="form__input">
				<?php the_field('header_blurb'); ?>
				</span>
			</div>
			<div class="medium-6 columns">
				<?php if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( 1 ); }; ?>
			</div>
		</div>
	</section>
	
	<section class="clearfix l-map">
		<div class="tile-panel">
			<div id='ag_map'></div>
		</div>
		<div class="tile-panel">
			<div class="row l-gray-light">
				<div class="large-10 large-offset-1 columns">
					<span class="post__sectiontitle text--bold">Getting to our office</span> <img class="icon--map" src="<?php echo get_stylesheet_directory_uri() ; ?>/assets/img/icons/icon-map-pin.png" />
					<br /><br />
					<address class="vcard"> 
						<div class="adr"><span class="street-address">51 Waterloo St #03-06</span>, <span class="locality">Singapore</span> <span class="postal-code">187969</span></div>
						<div class="tel">+65 6337 6642</div>
					</address>
					<br /><br />
					We encourage using public transportation or taxis as parking nearby can be difficult. Our nearest MRT station is Bras Basah.
					<br /><br />
					<span class="post__sectiontitle text--bold">Parking Directions</span> <img class="icon--map" src="<?php echo get_stylesheet_directory_uri() ; ?>/assets/img/icons/icon-map-p.png" />
					<br /><br />
					The nearest carpark is located underground at NTUC and can be accessed from Queen Street. To get to our office, walk along Queen Street towards Middle Road. Turn left into the small street in front of Oxford Hotel and continue past the painted wall mural. Walk into the white colonial building and up to the 3rd floor. Make a right and you’ll find our office at the end of the hall! 			</div>
		</div>		
	</section>
			
	<?php endwhile; // end of the loop. ?>		

</article>
	
	<?php get_template_part('parts/careers'); ?>

	<?php do_action('foundationPress_after_content'); ?>

<?php get_footer(); ?>
