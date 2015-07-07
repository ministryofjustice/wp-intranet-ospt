<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Config;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Config\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return '';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Remove post metaboxes
 */
function remove_elements() {
  remove_meta_box( 'categorydiv','post','normal' );
  remove_meta_box( 'tagsdiv-post_tag','post','normal' );
  remove_meta_box( 'revisionsdiv','post','normal' );
  remove_meta_box( 'commentsdiv','post','normal' );

  remove_meta_box( 'dashboard_primary', 'dashboard', 'normal');

  remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
  remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');

  remove_menu_page( 'edit-comments.php' );

  remove_post_type_support( 'post', 'editor' );
}
add_action('admin_menu', __NAMESPACE__ . '\\remove_elements');


/**
 * Output the ACF field content instead of the_content if we are in the category news
 */
function post_content_output($content) {
  global $post;

  $category = get_the_category( $post->ID );
  $acf_content = get_field( 'content', $post->ID );

  if($post->post_type == "post" && $category[0]->cat_name == "News" && !empty($acf_content)) {
    $content = $acf_content;
  }
  return $content;
}
add_filter( 'the_content', __NAMESPACE__ . '\\post_content_output' );

/**
 * Output the ACF field content instead of the_content if we are in the category news
 */
function post_permalink_output($content) {
  global $post;

  $category = get_the_category( $post->ID );
  $acf_content = get_field( 'document', $post->ID );

  if($post->post_type == "post" && $category[0]->cat_name == "Office Notices" && !empty($acf_content)) {
    $content = $acf_content;
  }
  return $content;
}
add_filter( 'the_permalink', __NAMESPACE__ . '\\post_permalink_output' );

/**
 * Get the most top parent ID
 */
function get_top_parent_ID() {
  global $post;
  $parents = get_post_ancestors( $post->ID );
  $id = ($parents) ? $parents[count($parents)-1]: $post->ID;
  return $id;
}

function get_news_posts($type, $year) {
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'year' => $year,
    'category_name' => $type
  );
  $query = new \WP_Query($args);
  return $query;
}

function get_single_category() {
  global $post;

  $category = get_the_category( $post->ID );
  return $category[0]->cat_name;
}

function nav_class ($classes, $item) {

    if (in_array('current-menu-item', $classes)){
        $classes[] = 'section1 current';
    }

    if(is_single() && get_post_type() == 'post' && $item->title == 'News' || in_array('current-page-ancestor', $classes)) {
      $classes[] = 'open';
    }

    return $classes;
}
add_filter('nav_menu_css_class' , __NAMESPACE__ . '\\nav_class' , 10 , 2);


function redirect_post() {
  if ( is_single() && get_post_type() == 'post' && get_single_category() == "Office Notices") {
    wp_redirect( home_url(), 301 );
    exit;
  }

  $category = get_single_category();
  $year = get_query_var('year');
  if( (is_category('News') || is_category('Office Notices')) && empty($year) )  {
    $category_id = get_cat_ID( $category  );
    $category = get_category( $category_id );
    wp_redirect( home_url() . '/' . $category->slug . '/' . date('Y') , 301 );
    exit;
  }
}
add_action( 'template_redirect', __NAMESPACE__ . '\\redirect_post' );
