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
<style>
.image-box {
	text-align: center;
	height: 200px;
	line-height: 200px;
	margin-bottom: 10px;
}
.image-box img {
	max-height: 100%;
}
.title-box {
	height: 100px;
}
.title-box h5 {
	font-size: 1.1rem !important;
}
.content-box {
	font-size: 13px;
	height: 200px;
	overflow: hidden;
}
</style>
			<main class="site-main" id="main">
			<?php
				$args =  array(
					'posts_per_page' => 20,
				);
				$q = new WP_Query($args);

				//Сортируем посты по приоритету
				if ($q->have_posts()) {
					foreach($q->posts as $key => $post) {
						$q->posts[$key]->priority = intval(get_field('priority', $post->ID));
					}


					usort($q->posts, function($a, $b) {
						return $a->priority > $b->priority;
						// return intval(get_field('priority', $a->ID)) > intval(get_field('priority', $b->ID));
					});
				}
				$limit = 4;
				$counter = 0;
			?>
				<?php while ( $q->have_posts() ) : $q->the_post(); ?>
					<?php if ($counter==0):?>
					<div class="row" style="margin-bottom:30px;">
					<?php endif;?>
						<div class="col-3">
							<div class="title-box">
								<?php the_title( sprintf( '<h5 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' ); ?>
							</div>
							<div class="image-box">
								<?php
								$image_url = get_the_post_thumbnail_url( $post->ID, 'medium' );
								if (empty($image_url)) {
									//default img
								}
								?>
								<img src="<?= $image_url ?>" alt="<?= get_the_title() ?>">
							</div>
							<div class="content-box">
								<?php the_excerpt(); ?>
							</div>
							<?php understrap_entry_footer(); ?>
						</div>
					<?php 
					$counter++;
					if ($counter>=4):
						$counter = 0;
					?>
					</div>
					<?php endif;?>
				<?php endwhile; // end of the loop. ?>
				<?php if ($counter>0):?>
					</div>
				<?php endif;?>
			</main><!-- #main -->

		</div><!-- #primary -->

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>