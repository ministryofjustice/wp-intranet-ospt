<!-- footer starts -->
<div id="footer">
  <div id="footer-container">
    <span class="footer-date">Page last updated on <?php the_modified_date('j F Y'); ?></span><br />
    <?php if ( $last_id = get_post_meta($post->ID, '_edit_last', true) ): $last_user = get_userdata($last_id); ?>
      <a href="mailto:<?= $last_user->user_email; ?>"><?= $last_user->display_name; ?></a> |
    <?php endif; ?>
    &copy; <a href="#">Crown Copyright</a>
  </div>
</div><!-- footer ends -->
