<?php

namespace Roots\Sage\Assets;

function assets()
{
    global $wp_styles;

    $common_path = trailingslashit(get_template_directory_uri()) . 'assets/';
    $assets = [
        'css' => [
            'reset' => $common_path . 'css/reset.css',
            'global' => $common_path . 'css/global.css',
            'colours' => $common_path . 'css/colours.css',
            'pretty-photo' => $common_path . 'css/prettyphoto.css',
            'news' => $common_path . 'css/news.css',
            'ie6' => $common_path . 'css/ie6.css',
        ],
        'js' => [
            'jquery' => $common_path . 'js/jquery.js',
            'cookies' => $common_path . 'js/cookies.js',
            'easy-slider' => $common_path . 'js/easyslider.js',
            'pretty-photo' => $common_path . 'js/prettyphoto.js',
            'tabs' => $common_path . 'js/tabs.js',
            'search-box' => $common_path . 'js/searchbox.js',
            'general' => $common_path . 'js/general.js',
        ]
    ];

    wp_enqueue_style('reset', $assets['css']['reset'], false, null);
    wp_enqueue_style('global', $assets['css']['global'], false, null);
    wp_enqueue_style('colours', $assets['css']['colours'], false, null);
    wp_enqueue_style('pretty-photo', $assets['css']['pretty-photo'], false, null);
    wp_enqueue_style('news', $assets['css']['news'], false, null);
    wp_enqueue_style('ie6', $assets['css']['ie6'], false, null);
    $wp_styles->add_data('ie6', 'conditional', 'IE 6');

    wp_enqueue_script('jquery-old', $assets['js']['jquery'], false, null);
    wp_enqueue_script('cookies', $assets['js']['cookies'], false, null);
    wp_enqueue_script('easy-slider', $assets['js']['easy-slider'], false, null);
    wp_enqueue_script('pretty-photo', $assets['js']['pretty-photo'], false, null);
    wp_enqueue_script('tabs', $assets['js']['tabs'], false, null);
    wp_enqueue_script('search-box', $assets['js']['search-box'], false, null);
    wp_enqueue_script('general', $assets['js']['general'], false, null);
}

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);
