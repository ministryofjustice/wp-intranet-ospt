<?php while (have_posts()) : the_post(); ?>
  <h2><?php the_title(); ?></h2>
  <?php get_template_part('templates/entry-meta'); ?>
  <?php the_content(); ?>
<?php endwhile; ?>
