<?php use Roots\Sage\Extras; ?>
<?php if(Extras\get_single_category() == "News"): ?>
  <div class="clearfix">
    <a href="<?php the_permalink(); ?>"><span class="title"><?php the_title(); ?></span> <span class="desc"><strong><?= get_the_date(); ?></strong><br /></span></a>
  </div>
<?php elseif(Extras\get_single_category() == "Office Notices"): ?>
  <li>
    <a href="<?php the_permalink(); ?>" title="opens a new window" target="_blank"><?php the_title(); ?></a><br />
    <strong><?= get_the_date(); ?></strong>
  </li>
<?php endif; ?>
