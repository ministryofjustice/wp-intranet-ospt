<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/page', 'header'); ?>
  <?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>

<?php

$args = array(
  'post_parent' => get_the_ID(),
  'post_type'   => 'page',
  'numberposts' => -1,
  'post_status' => 'publish'
);

$children = get_children($args);

?>

<?php if(!empty($children)): ?>
  <?php foreach ($children as $key => $value): ?>
    <div class="landing-box">
      <h2><a href="<?= the_permalink($key); ?>"><?= get_the_title($key); ?></a></h2>
    </div>
  <?php endforeach; ?>

  <div class="clear"></div>
<?php endif; ?>
