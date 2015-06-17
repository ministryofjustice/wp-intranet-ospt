<div class="all-header">
  <div id="header">
    <a accesskey="1" href="/"><img src="<?= get_stylesheet_directory_uri(); ?>/structure-images/logo.gif" alt="MoJ home" width="188" height="68" border="0" /></a>
  </div><!-- start of global navigation (top horizontal bar -->
  <!-- globalNav starts -->
  <div id="globalNav" class="globalnav-inner">
    <!-- div id="globalNav-inner" -->
    <div class="menu globalnav horizontal grey">
      <?php
      $args = array(
        'container_id'    => '',
        'menu_class'      => '',
        'link_before'     => '<span class="menu_ar">',
        'link_after'      => '</span>',
        'menu'            => 'Primary Navigation',
      );
      wp_nav_menu($args);
      ?>
    </div>
    <?= get_search_form(); ?>
  </div><!-- /div -->
  <!-- globalNav ends -->
</div>
