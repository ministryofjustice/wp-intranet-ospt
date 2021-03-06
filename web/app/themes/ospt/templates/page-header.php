<?php

use Roots\Sage\Titles;
use Roots\Sage\Extras;

$id = Extras\get_top_parent_ID();

?>
<?php if(get_post_type() == 'post' && is_single() ): ?>
  <h1>News</h1>
<?php elseif($id != get_the_ID()): ?>
  <h1><?= get_the_title( $id ); ?></h1>
  <h2><?= Titles\title(); ?></h2>
<?php else: ?>
  <h1><?= Titles\title(); ?></h1>
<?php endif; ?>
