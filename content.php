<?php if ( is_singular() ): ?>
	<div class="card text-light bg-secondary">
		<?php if ( has_post_thumbnail() ): ?>
			<?php the_post_thumbnail( 'large', ['class' => 'card-img-top'] ); ?>

			<div class="card-body">
				<h5 class="card-title"><?php the_title(); ?></h5>
				<p class="card-text"><?php the_content(); ?></p>
			</div>
		<?php else: ?>
			<div class="card-header"><?php the_title(); ?></div>

			<div class="card-body">
				<p><?php the_content(); ?></p>
			</div>
		<?php endif; ?>
	</div>
<?php else: ?>
	<div class="card text-light bg-secondary mt-2">
		<div class="card-header"><?php the_title(); ?></div>
		<div class="card-body row">
			<?php if ( has_post_thumbnail() ): ?>
				<?php $colClass = 'col-md-8' ?>

				<div class="col-md-4">
					<?php the_post_thumbnail( 'medium', ['class' => 'img-fluid'] ); ?>
				</div>
			<?php else: ?>
				<?php $colClass = 'col' ?>
			<?php endif; ?>

			<div class="<?php echo $colClass ?>">
				<div class="card-text"><?php the_excerpt(); ?></div>
				<a class="btn btn-primary" href="<?php echo esc_url(get_permalink()); ?>">Read more...</a>
			</div>
		</div>
	</div>
<?php endif; ?>
