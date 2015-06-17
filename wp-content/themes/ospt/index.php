<?php
/*
use Roots\Sage\Extras;

$news = Extras\get_news_posts('news', date('Y'));
$office_notices = Extras\get_news_posts('office-notices', date('Y'));

?>

<?php get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
<?php endif; ?>

<!-- menu tab starts-->
<div id="tabs-panel" class="content-switcher-newspanel1">
  <ul id="tabs">
    <?php if ($news->have_posts()) : ?>
    <li>
      <a href="#panel_1">News</a>
    </li>
    <?php endif; ?>
    <?php if ($office_notices->have_posts()) : ?>
    <li>
      <a href="#panel_2">Office Notices</a>
    </li>
    <?php endif; ?>
  </ul><!-- News section begins -->
  <div id="panel_1">
    <h2>
      News
    </h2>
    <div class="promo-container">
      <?php while ($news->have_posts()) : $news->the_post(); ?>
        <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
      <?php endwhile; ?>
    </div>
    <p>
      <a href="778.htm">Older news &raquo;</a>
    </p>
    <div class="hidden">
      <ul>
        <li>
          <a href="778.htm">News 2014</a>
        </li>
        <li>
          <a href="news-2013.htm">News 2013</a>
        </li>
        <li>
          <a href="696.htm">News 2012</a>
        </li>
        <li>
          <a href="news-2011.htm">News 2011</a>
        </li>
        <li>
          <a href="ospt-intranet.htm">News 2010</a>
        </li>
        <li>
          <a href="news-2009.htm">News 2009</a>
        </li>
      </ul>
    </div>
  </div><!-- News section ends -->
  <!-- Office notices section begins -->
  <div id="panel_2">
    <h2>
      Office notices
    </h2>
    <div class="annoucements">
      <ul class="hide-reddot">
        <?php while ($office_notices->have_posts()) : $office_notices->the_post(); ?>
          <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
        <?php endwhile; ?>
      </ul>
    </div>
    <p>
      <a href="office-notices-2013.htm">Older office notices &raquo;</a>
    </p>
    <div class="hidden">
      <ul>
        <li>
          <a href="779.htm">Office notices 2014</a>
        </li>
        <li>
          <a href="office-notices-2013.htm">Office notices 2013</a>
        </li>
        <li>
          <a href="office-notices-2012.htm">Office notices 2012</a>
        </li>
        <li>
          <a href="office-notices-2011.htm">Office notices 2011</a>
        </li>
        <li>
          <a href="office-notices-2010.htm">Office notices 2010</a>
        </li>
      </ul>
    </div>
  </div><!-- Office notices section ends -->
</div><!-- menu tab ends--> */ ?>
