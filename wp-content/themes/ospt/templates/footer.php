<!-- footer starts -->
<div id="footer">
  <div id="footer-container">
    <span class="footer-date">Page last updated on <?php the_modified_date('j F Y'); ?></span><br />
    <?php
      $last_id = get_post_meta($post->ID, '_edit_last', true);
      if(!empty($last_id)) {
        $last_user = get_userdata($last_id);
      }
      ?>
    <?php if (!empty($last_user) && !strpos($last_user->user_email, '@digital.justice.gov.uk')):  ?>
      <a href="mailto:<?= $last_user->user_email; ?>"><?= $last_user->display_name; ?></a> |
    <?php else: ?>
      <a href="mailto:julie.taylor@offsol.gsi.gov.uk">Julie Taylor</a> |
    <?php endif; ?>
    &copy; <a href="#">Crown Copyright</a>
  </div>
</div><!-- footer ends -->
