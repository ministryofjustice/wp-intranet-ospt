<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <?php get_template_part('templates/head'); ?>
  <body class="section1">
    <!-- wrapper starts -->
    <div id="wrapper">
      <!-- inner wrapper starts -->
      <div id="inner-wrapper">
        <?php
          do_action('get_header');
          get_template_part('templates/header');
        ?>

        <div class="main-wrapper">

          <?php if (Config\display_sidebar()) : ?>
            <?php include Wrapper\sidebar_path(); ?>
          <?php endif; ?>

          <!-- main content starts -->
          <div id="mainContent" class="">
            <?php include Wrapper\template_path(); ?>
          </div><!-- main content ends -->
          <div class="clear"></div>
        </div>

        <?php
          do_action('get_footer');
          get_template_part('templates/footer');
          wp_footer();
        ?>
        <div id="push"></div>
      </div><!-- inner wrapper ends -->
    </div><!-- wrapper ends -->
  </body>
</html>
