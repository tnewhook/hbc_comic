<?php
/**
 * The template for displaying single posts and pages.
 *
 * Template Name: HBC Comic
 * Template Post Type: comic,
 */

get_header();
?>

<main id="site-content" role="main">
	<?php
if ( have_posts() ) {

	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_type() );
	}
}
	?>

</main><!-- #site-content -->
<button type="button" class="btn btn-info">Open Modal</button>
<?php  get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
