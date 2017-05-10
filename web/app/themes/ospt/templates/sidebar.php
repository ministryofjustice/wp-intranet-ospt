<?php $related_links = get_field('links'); $document_downloads = get_field('document_downloads'); ?>
<!-- left column/navigation starts -->
<div id="leftColumn" class="">
  <!-- sections starts -->
  <?php
  $args = array(
    'menu_class'      => 'sections',
    'menu_id'         => 'sections',
    'menu'            => 'Secondary Navigation',
    'fallback_cb'     => false,
    'echo'            => false,
    'depth'           => 2,
  );
  $test = wp_nav_menu($args);
  echo str_replace('class="sub-menu"', 'id="sub-level"', $test);
  ?>
</div><!-- left column/navigation ends -->

<?php if(is_front_page()): ?>
  <!-- right column starts -->
  <div id="rightColumn" class="">
    <?php /*<!-- module starts -->
    <div class="module calendar">
      <div class="heading" id="panel_3">
        Events calendar
      </div><img src="<?= get_stylesheet_directory_uri(); ?>/structure-images/events.jpg" alt="events calendar" />
      <p class="more">
        <a href="/news#panel_4">Full details of events &raquo;</a>
      </p>
    </div>
    <!-- module ends -->*/ ?>
    <!-- module starts -->
    <div class="module">
      <div class="heading">
        News feeds
      </div><img src="<?= get_stylesheet_directory_uri(); ?>/structure-images/rss-news.jpg" />
      <div class="rss accordian">
        <?php /*<p class="accordian-heading">
          Justice.gov.uk news feed
        </p>
        <div>
          <p>
            Latest news from the MoJ internet
          </p><script language="javascript" src="http://feed2js.org//feed2js.php?src=http%3A%2F%2Fwww.justice.gov.uk%2Frss%2Fnews.xml&amp;num=3&amp;desc=0&amp;date=n&amp;targ=y" type="text/javascript">
  </script>
        </div> */ ?>
        <p class="accordian-heading">
          BBC politics
        </p>
        <div class="default">
          <p>
            Latest politics news from the BBC
          </p><script language="javascript" src="http://feed2js.org//feed2js.php?src=http%3A%2F%2Fnewsrss.bbc.co.uk%2Frss%2Fnewsonline_uk_edition%2Fuk_politics%2Frss.xml&amp;num=3&amp;desc=0&amp;date=n&amp;targ=y" type="text/javascript">
  </script>
        </div>
        <?php /*<p class="accordian-heading">Parliament</p>
        <div>
          <p>Latest news from <a href="">www.parliament.uk</a></p>
          <script language="javascript" src="http://feed2js.org//feed2js.php?src=http%3A%2F%2Ffeeds2.feedburner.com%2Fparliamentnews%2F&amp;num=3&amp;desc=0&amp;date=n&amp;targ=y" type="text/javascript"></script>
        </div>*/ ?>
      </div>
    </div><!-- module ends -->
  </div><!-- right column ends -->
<?php endif; ?>


<?php if(!empty($related_links) || !empty($document_downloads)): ?>
  <div id="rightColumn">
  <?php if( have_rows('links') ): ?>
  <!-- related links box starts -->
  <div class="module">
    <div class="heading"><h2>Related links</h2></div>
    <ul>
      <?php while( have_rows('links') ): the_row(); ?>
        <li><a href="<?= get_sub_field('link'); ?>"><?= get_sub_field('title'); ?></a></li>
      <?php endwhile; ?>
    </ul>
  </div>
  <!-- related links box ends -->
  <?php endif; ?>

  <?php if( have_rows('document_downloads') ): ?>
  <!-- related links box starts -->
  <div class="module">
    <div class="heading"><h2>Document downloads</h2></div>
    <ul>
      <?php while( have_rows('document_downloads') ): the_row(); ?>
        <li><a href="<?= get_sub_field('file'); ?>"><?= get_sub_field('title'); ?></a></li>
      <?php endwhile; ?>
    </ul>
  </div>
  <!-- related links box ends -->
  <?php endif; ?>
</div>
<?php endif; ?>
