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

/**
 * Get posts for category within the specified year.
 *
 * @param string $type
 * @param mixed $year
 * @return \WP_Query
 */
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

/**
 * Get latest posts for category, limited by date or count.
 *
 * @param string $type Post category
 * @param string $maxAge Max age for posts, default "1 month"
 * @param int $limitCount Limit to count, default no limit (null)
 * @return \WP_Query
 */
function get_latest_news_posts($type, $maxAge = '1 month', $limitCount = null) {
  $args = array(
      'post_type' => 'post',
      'posts_per_page' => -1,
      'category_name' => $type
  );

  // Limit by date
  if (!is_null($maxAge)) {
    $now = time();
    $aged = strtotime($maxAge, $now);
    $timestamp = strtotime('-1 day', $now - ( $aged - $now ));
    $afterDate = array(
      'year'  => date('Y', $timestamp),
      'month' => date('m', $timestamp),
      'day'   => date('j', $timestamp),
    );
    $args['date_query']['after'] = $afterDate;
  }

  // Limit count
  if (!is_null($limitCount)) {
    $args['posts_per_page'] = $limitCount;
  }

  $query = new \WP_Query($args);
  return $query;
}

function get_single_category() {
  global $post;

  $category = get_the_category( $post->ID );
  if (empty($category)) return null;
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
    $archiveYears = get_archive_years_for_category($category->slug, 1);

    if (count($archiveYears) > 0) {
      $year = $archiveYears[0];
    } else {
      $year = date('Y');
    }

    wp_redirect(home_url() . '/' . $category->slug . '/' . $year . '/', 302);
    exit;
  }
}
add_action( 'template_redirect', __NAMESPACE__ . '\\redirect_post' );

/**
 * Dynamically add yearly archive links to "News" and "Office Notices" menu items.
 *
 * @param array $items
 * @return array
 */
function menu_archive_links($items) {
  foreach ($items as $item) {
    if (in_array($item->title, array('News', 'Office Notices'))) {
      $category = $item->title == 'Office Notices' ? 'office-notices' : 'news';
      $archiveItems = get_year_archive_menu_items($item, $category);

      if (count($archiveItems) > 0) {
        $item->classes[] = 'menu-item-has-children';
      }

      if (is_category($category)) {
        $item->classes[] = 'current-menu-ancestor';
        $item->classes[] = 'current-menu-parent';
        $item->classes[] = 'current_page_parent';
        $item->classes[] = 'current_page_ancestor';
      }

      $items = array_merge($items, $archiveItems);
    }
  }
  return $items;
}
add_filter('wp_nav_menu_objects', __NAMESPACE__ . '\\menu_archive_links');

/**
 * Return menu items for the supplied category link.
 *
 * @param \WP_Post $parentItem
 * @param string $category
 * @return array
 */
function get_year_archive_menu_items(\WP_Post $parentItem, $category) {
  $years = get_archive_years_for_category($category);

  $items = array();
  foreach ($years as $year) {
    $classes = array();
    if (is_category($category) && $year == get_query_var('year')) {
      $classes[] = 'current';
    }

    $link = array(
      'title' => $year,
      'menu_item_parent' => $parentItem->ID,
      'ID' => $parentItem->ID . '-' . $year,
      'db_id' => '',
      'url' => $parentItem->url . '/' . $year . '/',
      'classes' => $classes,
    );

    $items[] = (object) $link;
  }

  return $items;
}

/**
 * Get available archive years for category slug.
 *
 * @param string $category Category slug
 * @param int $limit
 * @return array
 */
function get_archive_years_for_category($category, $limit = 0) {
  global $wpdb;

  $sql = "SELECT YEAR($wpdb->posts.post_date) AS year
          FROM $wpdb->posts
          LEFT JOIN $wpdb->term_relationships ON ( $wpdb->term_relationships.object_id = $wpdb->posts.ID )
          LEFT JOIN $wpdb->term_taxonomy ON ( $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id )
          LEFT JOIN $wpdb->terms ON ( $wpdb->terms.term_id = $wpdb->term_taxonomy.term_id )
          WHERE $wpdb->posts.post_type = 'post'
          AND $wpdb->posts.post_status = 'publish'
          AND $wpdb->terms.slug = %s
          GROUP BY YEAR($wpdb->posts.post_date)
          ORDER BY $wpdb->posts.post_date DESC";

  $prepareVars = array(
      $category,
  );

  if ($limit > 0) {
    $sql .= "\n LIMIT %d";
    $prepareVars[] = $limit;
  }

  $sql = $wpdb->prepare($sql, $prepareVars);
  $results = $wpdb->get_col($sql, 0);
  return array_map('intval', $results);
}
