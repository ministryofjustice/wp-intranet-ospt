<?php header("Content-Type: text/html; charset=UTF-8"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php

require('vendor/autoload.php');
require($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
use Goutte\Client;

/**
 * ExportSite
 *
 * This class will crawl all specified links of a given website
 * and export/import for WordPress
 *
 * @package ExportSite
 * @author  Toby Schrapel <https://github.com/schrapel>
 * @version 1.0.0
 */
class ScrapeSite
{
  /**
   * The CSV files used to import URLs
   * @var string
   */
  protected $csv;
  /**
   * The JSON file used to export data
   * @var string
   */
  protected $json;
  /**
   * Should we import the JSON?
   * @var boolean
   */
  protected $import;

  /**
   * Constructor
   * @param string    $csv
   * @param string    $json
   */
  public function __construct($csv, $json, $import)
  {
    $this->csv = $csv;
    $this->json = $json;
    $this->import = $import;
    $this->scrape($this->loadUrls());
    $this->import();
  }

  /**
   * Initiates the scrape of URLs
   * @param array    $urls
   */
  protected function scrape($urls)
  {
    $scrape = [];
    foreach($urls as $url) {
      $result = $this->crawl($url);
      if(!empty($result)) {
        if (is_array($result[0])) {
          $scrape = array_merge($scrape, $result);
        } else {
          $scrape[] = $result;
        }
      }
    }

    if(count($urls) != count($scrape)) {
      print "The URL count does not equal the scrape count...<br>";
    }

    if(!empty($scrape)) {
      usort($scrape, function($a, $b) {
        return strcmp($a['post_parent'], $b['post_parent']);
      });
      foreach ($scrape as $index => $array) {
        if(empty($array['post_parent'])) {
          $scrape = array($index => $scrape[$index]) + $scrape;
        }
      }
      $this->saveJson($scrape);
      //var_dump($scrape);
    } else {
      print "The scrape does not contain any posts/pages...<br>";
      die();
    }
  }

  /**
   * Load URLs from CSV file
   */
  protected function loadUrls()
  {
    $csv_file = fopen($this->csv, "r");
    $csv_contents = fread($csv_file, filesize($this->csv));
    $urls = explode("\n", $csv_contents);
    $urls = array_filter($urls, array($this, 'ignore_pages'));
    print "URLs loaded successfully...<br>";
    return $urls;
  }

  protected function ignore_pages($var)
  {
    $ignore = [
      "http://intranet-ospt.dev/export/dump/index.htm",
      "http://intranet-ospt.dev/export/dump/news-and-events.htm",
      "http://intranet-ospt.dev/export/dump/778.htm",
      "http://intranet-ospt.dev/export/dump/news-2013.htm",
      "http://intranet-ospt.dev/export/dump/696.htm",
      "http://intranet-ospt.dev/export/dump/news-2011.htm",
      "http://intranet-ospt.dev/export/dump/ospt-intranet.htm",
      "http://intranet-ospt.dev/export/dump/news-2009.htm",
      "http://intranet-ospt.dev/export/dump/office-notices-2012.htm",
      "http://intranet-ospt.dev/export/dump/office-notices-2011.htm",
      "http://intranet-ospt.dev/export/dump/office-notices-2013.htm",
      "http://intranet-ospt.dev/export/dump/779.htm",
      "http://intranet-ospt.dev/export/dump/office-notices-2010.htm",
    ];
    preg_match("/http:\/\/intranet-ospt.dev\/export\/dump\/[a-z].htm/", $var, $matches);
    if(!empty($matches) || in_array($var, $ignore)) {
      return false;
    } else {
      return true;
    }
  }

  /**
   * Saves scraped content to JSON file
   * @param array     $scrape
   */
  protected function saveJson($scrape)
  {
    $json_file = fopen("export.json", "w");
    fwrite($json_file, json_encode($scrape));
    fclose($json_file);
    print "JSON has been saved successfully...<br>";
  }

  /**
   * Crawl a individual page
   * @param string    $url
   */
  protected function crawl($url)
  {
    try {
      $client = new Client();
      $client->followRedirects();

      $crawler = $client->request('GET', $url);
      $status_code = $client->getResponse()->getStatus();

      if($status_code === 200) {
        $content_type = $client->getResponse()->getHeader('Content-Type');
        if (strpos($content_type, 'text/html') !== false) {

          $post_type = $this->postType($crawler, $url);
          //$this->checkSidebar($crawler, $url);
          if($post_type == "page") {
            $scrape = [
              "post_title" => $this->postTitle($crawler, $url),
              "post_content" => $this->postContent($crawler, $post_type),
              "post_name" => $this->postName($url),
              "post_date" => $this->pageDate($crawler, $url),
              "post_parent" => $this->postParent($crawler),
              "post_type" => $post_type
            ];
          } elseif($post_type == "post_news") {
            $scrape = [
              "post_title" => $this->postTitle($crawler, $url),
              "post_content" => $this->postContent($crawler, $post_type),
              "post_name" => $this->postName($url),
              "post_date" => $this->postDate($crawler, $url),
              "post_type" => 'post',
              'post_category' => 1,
            ];
          } elseif($post_type == "post_office_notices") {

          }

          if(!empty($scrape)) {
            //print "Saved: " . $url . "<br>";
            return $scrape;
          } else {
            print "Error Saving: " . $url . "<br>";
          }
        }
      }
    } catch(Exception $e) {
      print "Fatal Error";
      die();
    }
  }

  /**
   * Check for sidebar widget
   * @param DomCrawler $crawler
   */
  protected function checkSidebar($crawler, $url)
  {
    $crawler->filter('#rightColumn .module')->each(function ($node, $i) use (&$url) {
      print "Sidebar on: " . $url . "<br>";
    });
  }

  /**
   * Scrape the post title
   */
  protected function postTitle($crawler, $url)
  {
    $crawler->filter('#mainContent')->each(function ($node, $i) use (&$post_title, &$url) {
      $html = $node->html();
      preg_match('/^\s*<h1>\s*(.+)\s*<\/h1>\s*<h2>\s*(.+)\s*<\/h2>/', $html, $h2);
      preg_match('/^\s*<h1>\s*(.+)\s*<\/h1>/', $html, $h1);
      if(!empty($h2[2])) {
        $post_title = $h2[2];
      } elseif(!empty($h1[1])) {
        $post_title = $h1[1];
      } else {
        print "Can't find Title on: " . $url . "<br>";
      }

    });
    return htmlspecialchars_decode($post_title);
  }

  /**
   * Scrape the post content
   */
  protected function postContent($crawler, $post_type)
  {
    $crawler->filter('#mainContent')->each(function ($node, $i) use (&$post_content) {
      $post_content = $node->html();
      $post_content = preg_replace('/^\s*<h1>\s*(.+)\s*<\/h1>\s*<h2>\s*(.+)\s*<\/h2>/', "", $post_content);
      $post_content = preg_replace('/^\s*<h1>\s*(.+)\s*<\/h1>/', "", $post_content);
      $post_content = preg_replace("/<!--.*-->/", "", $post_content);
      $post_content = preg_replace("/http:\/\/intranet.justice.gsi.gov.uk\/ospt/", "/", $post_content);
      $post_content = preg_replace("/<div class=\"imageBox\"><\/div>/", "", $post_content);

      if($post_type = "post_news") {
        $post_content = preg_replace('/^\s*<h3>\s*(.+)\s*<\/h3>/', "", $post_content);
      }

      $post_content = preg_replace_callback(
        "#(<\s*a\s+[^>]*href\s*=\s*[\"'])(?!http|mailto|javascript|\#)([^\"'>]+)([\"'>]+)#",
        function($matches) {
          $matches[2] = str_replace(".htm", "", $matches[2]);
          $matches[2] = preg_replace("/(..\/|\/|)+docs\//", "/wp-content/uploads/", $matches[2]);
          $matches[2] = preg_replace("/(..\/|\/|)+images\//", "/wp-content/uploads/", $matches[2]);
          if(is_numeric($matches[2])) {
            $matches[2] .= "-2";
          }
          return $matches[1] . $matches[2] . $matches[3];
        },
        $post_content
      );

      $post_content = preg_replace_callback(
        "#(<\s*img\s+[^>]*src\s*=\s*[\"'])(?!http|mailto|javascript|\#)([^\"'>]+)([\"'>]+)#",
        function($matches) {
          $matches[2] = preg_replace("/(..\/|\/|)+images\//", "/wp-content/uploads/", $matches[2]);
          return $matches[1] . $matches[2] . $matches[3];
        },
        $post_content
      );

      $post_content = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $post_content);
      $post_content = mb_convert_encoding($post_content, 'HTML-ENTITIES', 'iso-8859-1');
      $post_content = utf8_encode($post_content);
      $post_content = trim($post_content);

    });
    return $post_content;
  }

  /**
   * Calculate the post type
   */
  protected function postType($crawler, $url)
  {
    $crawler->filter('title')->each(function ($node, $i) use (&$post_type) {
      $title = $node->text();
      if(strpos($node->text(), "News & events - Office notices")) {
        $post_type = "post_office_notices";
      } elseif(strpos($node->text(), "News - ")) {
        $post_type = "post_news";
      } else {
        $post_type = "page";
      }
    });
    return $post_type;
  }

  /**
   * Scrape a post parent
   */
  protected function postParent($crawler)
  {
    $crawler->filter('title')->each(function ($node, $i) use (&$post_parent) {
      $parts = explode("-", $node->text());
      if(count($parts) == 2) {
        $post_parent = trim($parts[0]);
        $post_parent = str_replace("Business information & reports", "Business information and reports", $post_parent);
      }
    });
    return $post_parent;
  }

  /**
   * Scrape a post slug
   */
  protected function postName($url)
  {
    $parsed_url = parse_url($url);
    $path = $parsed_url['path'];
    $directories = explode('/', $path);
    $post_name = str_replace(".htm", "", end($directories));

    if(is_numeric($post_name)) {
      $post_name .= "-2";
    }
    return $post_name;
  }

  /**
   * Scrape a page date
   */
  protected function pageDate($crawler, $url)
  {
    $crawler->filter('.footer-date')->each(function ($node, $i) use (&$date) {
      $text = $node->text();
      $pattern = '/Page last updated on (\d{2}\s[A-Za-z]+\s\d{4})/';
      preg_match($pattern, $text, $matches);
      if(!empty($matches[1])) {
        $date = preg_replace($pattern, "$1", $text);
      }
    });
    if(empty($date)) {
      print "Date Missing: " . $url . "<br>";
      return;
    } else {
      $date = DateTime::createFromFormat('d F Y', $date);
      $date = $date->format('Y-m-d H:i:s');
      return $date;
    }
  }

  /**
   * Scrape a post date
   */
  protected function postDate($crawler, $url)
  {
    $crawler->filter('#mainContent')->each(function ($node, $i) use (&$post_date, &$url) {
      $html = $node->html();
      preg_match('/^\s*<h1>\s*(.+)\s*<\/h1>\s*<h2>\s*(.+)\s*<\/h2>\s*<h3>\s*(.+)\s*<\/h3>/', $html, $date);
      if(!empty($date[3])) {
        $post_date = DateTime::createFromFormat('d F Y', trim($date[3]));
        $post_date = $post_date->format('Y-m-d H:i:s');
      } else {
        print "Date Missing: " . $url . "<br>";
      }

    });
    return $post_date;
  }

  /**
   * Import JSON file into WordPress
   */
  protected function import()
  {
    if($this->import == true) {
      $json = file_get_contents( $this->json );
      $pages = json_decode( $json );
      foreach ($pages as $page) {
        $post = array(
          'post_content' => $page->post_content,
          'post_title' => $page->post_title,
          'post_name' => $page->post_name,
          'post_date' => $page->post_date,
          'post_date_gmt' => $page->post_date,
          'post_type' => $page->post_type,
          'post_category' => array($page->post_category),
          'post_status' => 'publish',
          'post_parent' => $this->getID($page->post_parent),
        );

        $post_id = wp_insert_post( $post, $error );

        if(!empty($post_id) && !empty($page->post_category)) {
          update_field('field_55783009d0ba5', $page->post_category, $post_id);
        }

        if(!empty($post_id) && $page->post_type == 'post') {
          update_field('field_55794a1b32019', $page->post_content, $post_id);
        }

        if(!empty($error)) {
          print "There was an error importing the posts.";
          die();
        }
      }
    }
  }

  protected function getID($title) {
    if(empty($title)) {
      return;
    }
    $page = get_page_by_title($title);
    if ($page) {
      return $page->ID;
    } else {
      print "Failed to find Title: " . $title . "<br>";
      return null;
    }
  }
}

$export = new ScrapeSite("internal_html.csv", "export.json", false);
?>
</body>
</html>
