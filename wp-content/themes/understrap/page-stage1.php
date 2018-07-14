<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package understrap
 */

get_header();

$container   = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<main class="site-main" id="main">
			<?php
				$args =  array(
					'posts_per_page' => 20,
				);
				$q = new WP_Query($args);

				//Сортируем посты по приоритету
				if ($q->have_posts()) {
					usort($q->posts, function($a, $b) {
						return intval(get_field('priority', $a->ID)) > intval(get_field('priority', $b->ID));
					});
				}
			?>
				<?php while ( $q->have_posts() ) : $q->the_post(); ?>

					<?php get_template_part( 'loop-templates/content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?>
			</main><!-- #main -->

		</div><!-- #primary -->

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>