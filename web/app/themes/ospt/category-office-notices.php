<?php

use Roots\Sage\Extras;

$year = get_query_var('year');
if(empty($year)) $year = date('Y');
$office_notices = Extras\get_news_posts('office-notices', $year);
?>

<h1>Office Notices</h1>
<h2><?= $year; ?></h2>

<?php if (!$office_notices->have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
<?php endif; ?>

<?php if ($office_notices->have_posts()) : ?>
<div class="annoucements">
  <ul>
  <?php while ($office_notices->have_posts()) : $office_notices->the_post(); ?>
    <li>
      <a href="<?= the_permalink(); ?>"><?= get_the_title(); ?></a><br>
      <strong><?= get_the_date('j F Y'); ?></strong>
    </li>
  <?php endwhile; ?>
  </ul>
</div>
<?php endif; ?>
