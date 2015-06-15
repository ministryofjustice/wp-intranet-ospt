<?php

use Roots\Sage\Extras;

$news = Extras\get_news_posts('news', date('Y'));
$office_notices = Extras\get_news_posts('office-notices', date('Y'));

?>
<h1>
  Official Solicitor and Public Trustee intranet
</h1><!-- menu tab starts-->
<div id="tabs-panel">
  <ul id="tabs">
    <li>
      <a href="#panel_1">Recent office notices</a>
    </li>
    <li>
      <a href="#panel_2">Latestnews</a>
    </li>
  </ul><!-- Start of office notices list -->
  <div id="panel_1">
    <h2>
      Recent office notices
    </h2>
    <div class="annoucements">
      <ul class="hide-reddot">
        <?php while ($office_notices->have_posts()) : $office_notices->the_post(); ?>
          <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
        <?php endwhile; ?>
      </ul>
    </div>
  </div><!-- End of office notices list -->
  <!-- Start of news list -->
  <div id="#panel_2">
    <h2>
      Latest news
    </h2>
    <div class="promo-container">
      <?php while ($news->have_posts()) : $news->the_post(); ?>
        <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
      <?php endwhile; ?>
    </div>
  </div>
</div><!-- End of news list -->
