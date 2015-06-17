<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/page', 'header'); ?>
  <?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>

<?php

$args = array(
  'post_parent' => get_the_ID(),
  'post_type'   => 'page',
  'numberposts' => -1,
  'post_status' => 'publish',
  'orderby' => 'post_title',
  'order' => 'ASC'
);

$children = get_children($args);

?>

<?php if(!empty($children)): $count = 1; ?>
  <?php foreach ($children as $key => $value): $url = get_permalink($key); $url = parse_url($url); ?>
    <div class="landing-box">
      <h2><a href="<?= $url['path']; ?>"><?= get_the_title($key); ?></a></h2>
    </div>
    <?php if($count % 2 == 0): ?><div class="clear"></div><?php endif; ?>
  <?php $count++; endforeach; ?>

  <div class="clear"></div>
<?php endif; ?>
