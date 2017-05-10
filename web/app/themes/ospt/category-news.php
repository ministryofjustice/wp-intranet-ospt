<?php

use Roots\Sage\Extras;

$year = get_query_var('year');
if(empty($year)) $year = date('Y');
$news = Extras\get_news_posts('news', $year);
?>

<h1>News</h1>
<h2><?= $year; ?></h2>

<?php if (!$news->have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
<?php endif; ?>

<?php if ($news->have_posts()) : ?>
<div class="promo-container">
  <?php while ($news->have_posts()) : $news->the_post(); ?>
    <div class="clearfix">
      <a href="<?= the_permalink(); ?>"><span class="title"><?= get_the_title(); ?></span> <span class="desc"><strong><?= get_the_date('j F Y'); ?></strong><br></span></a>
    </div>
  <?php endwhile; ?>
</div>
<p class="back-to-top clearfix"><a href="#top">Back to top</a></p>
<?php endif; ?>
