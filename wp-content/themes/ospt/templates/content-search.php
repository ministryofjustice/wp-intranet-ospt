<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if (get_post_type() === 'post') { get_template_part('templates/entry-meta'); } ?>
<?php the_excerpt(); ?>
