<?php get_header( 'front' ); ?>
	<div class="container mt-2">
		<div class="row">
			<div class="card-deck">
				<?php for ($i=1; $i <= 2 ; $i++): ?>
					<?php $featured_post_id = get_theme_mod( 'custom_theme_featured_post_'.$i.'_setting' ); ?>

					<?php if ( $featured_post_id ): ?>
						<?php
							$args = array(
								'p' => $featured_post_id,
							);

							$featured_post = new WP_Query( $args );
						?>

						<?php if ( $featured_post->have_posts() ): ?>
							<?php while ( $featured_post->have_posts() ): $featured_post->the_post(); ?>
								<div class="card col-6 text-dark">
									<h3><?php the_title(); ?></h3>
									<p><?php the_content(); ?></p>
									<button type="button" name="button">Go To Post</button>
								</div>
							<?php endwhile; ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php endfor; ?>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<h1>Home Page</h1>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<?php if ( have_posts() ): ?>
					<?php get_template_part( 'carousel', 'Carousel' ); ?>

					<?php while ( have_posts() ): the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>

			<?php if ( is_active_sidebar('sidebar-main') ): ?>
				<div class="col-4">
					<div id="sidebar-main" class="card text-light bg-secondary p-2">
						<?php dynamic_sidebar( 'sidebar-main' ); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php get_footer(); ?>
