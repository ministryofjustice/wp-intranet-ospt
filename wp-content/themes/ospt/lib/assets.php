<?php

namespace Roots\Sage\Assets;

function assets() {
  global $wp_styles;

  wp_enqueue_style( 'reset', trailingslashit(get_template_directory_uri()) . 'reset.css', false, null  );
  wp_enqueue_style( 'global', trailingslashit(get_template_directory_uri()) . 'global.css', false, null  );
  wp_enqueue_style( 'colours', trailingslashit(get_template_directory_uri()) . 'colours.css', false, null  );
  wp_enqueue_style( 'prettyphoto', trailingslashit(get_template_directory_uri()) . 'prettyphoto.css', false, null  );
  wp_enqueue_style( 'news', trailingslashit(get_template_directory_uri()) . 'news.css', false, null  );
  wp_enqueue_style( 'ie6', trailingslashit(get_template_directory_uri()) . 'ie6.css', false, null  );
  $wp_styles->add_data( 'ie6', 'conditional', 'IE 6' );

  wp_enqueue_script( 'jquery-old', trailingslashit(get_template_directory_uri()) . 'jquery.js', false, null );
  wp_enqueue_script( 'cookies', trailingslashit(get_template_directory_uri()) . 'cookies.js', false, null );
  wp_enqueue_script( 'easyslider', trailingslashit(get_template_directory_uri()) . 'easyslider.js', false, null );
  wp_enqueue_script( 'prettyphoto', trailingslashit(get_template_directory_uri()) . 'prettyphoto.js', false, null );
  wp_enqueue_script( 'tabs', trailingslashit(get_template_directory_uri()) . 'tabs.js', false, null );
  wp_enqueue_script( 'searchbox', trailingslashit(get_template_directory_uri()) . 'searchbox.js', false, null );
  wp_enqueue_script( 'general', trailingslashit(get_template_directory_uri()) . 'general.js', false, null );
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);
