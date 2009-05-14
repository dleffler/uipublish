<?php
// $Id: rss.php,v 1.2 2003/06/19 16:01:30 chavan Exp $
//
// Prints out an RSS version of the lastest calendar items of this section.
//
// Print RSS header
echo "<?xml version=\"1.0\" ?>\n";
//echo "<rss xmlns:atom='http://www.w3.org/2005/Atom' xmlns:openSearch='http://a9.com/-/spec/opensearchrss/1.0/' version='2.0'>\n";
echo "<rss version=\"2.0\"" .
	"  xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"" .
	"  xmlns:wfw=\"http://wellformedweb.org/CommentAPI/\"" .
	"  xmlns:dc=\"http://purl.org/dc/elements/1.1/\"" .
	"  xmlns:itunes=\"http://www.itunes.com/dtds/podcast-1.0.dtd\"" .
	"  xmlns:media=\"http://search.yahoo.com/mrss/\">\n";
echo "<channel>\n";
// Require files
require ("../inc/config.php");
require ("../inc/globals.php");
require ("../inc/common.php");
require ("../inc/connect_db.php");
require ("../inc/display_err.php");
require ("../inc/format_date.php");
require ("section_id.php");
if (!function_exists('mime_content_type')) {
  require ("../inc/mime.php");
}
//
// ---- CONFIGURATION --------------------------------------------
// Set Paths
// Example: news/item.php?id=
$linkpath         = $base_url . $section_dir_cal[$section_id] . "/item1.php?id=";
// Configure RSS
$rss_title       = "Website Events";  
$rss_description = "Upcoming Events at Website"; 
$rss_lang        = "en-us";         // en-us for U.S. English, etc. 
$rss_imgtitle    = "Website";    // Powered by UIPublish
$rss_imgurl      = "http://www.website.com/images/website.gif";
$rss_imglink     = $base_url;
$rss_itemslimit  = "25"; // Maximum number of RSS items       
// ---------------------------------------------------------------
// Setup RSS 
$rss_link        = $base_url;
// Check for datetime. If date not given, print error message.
if ($now_datetime == "") {
  $rss_pubdate = "Date unavailable";
} else {
  // Parse datetime and split it up
  $year   = substr($now_datetime, 0, 4);
  $month  = substr($now_datetime, 5, 2);
  $day    = substr($now_datetime, 8, 2);
  $hour   = substr($now_datetime, 11, 2);
  $minute = substr($now_datetime, 14, 2);
  $second = substr($now_datetime, 17, 2);
}  
// Format publish date in RFC822 Format
//"YYYY-mm-dd HH:mm:ss" --> "Wed, 02 Oct 2002 13:00:00 GMT" RFC822 Format
$cal = date("D, d M Y", mktime($hour, $minute, $second, $month, $day, $year));
$time = date("H:i:s T", mktime($hour, $minute, $second, $month, $day, $year));
$rss_pubdate = "$cal $time";

if ( connect_db() == "failed") {
  echo Ffrmt_error("Unable to connect to the database.");
} else {
  // Print channel information
  echo "<title>"       . $rss_title       . "</title>\n";
  echo "<link>"        . $rss_link        . "</link>\n";
  echo "<description>" . $rss_description . "</description>\n";
  echo "<language>"    . $rss_lang        . "</language>\n";
  echo "<pubDate>"     . $rss_pubdate     . "</pubDate>\n";
  echo "<image>\n";
  echo "  <title>"     . $rss_imgtitle    . "</title>\n";
  echo "  <url>"       . $rss_imgurl      . "</url>\n";
  echo "  <link>"      . $rss_imglink     . "</link>\n";
  echo "</image>\n";
  echo "\n";
  $query = "SELECT ID, title, topic_id, summary, post_date, start_time, expire_date, link_url, filepath FROM $tbl_name_cal 
	       WHERE status = 1
	       AND section_id = '$section_id'
	       AND ( expire_date > '$now_datetime' OR expire_date = '0000-00-00')
	       ORDER BY post_date
               LIMIT $rss_itemslimit
	       ";  
  $result = mysql_query($query); 
  $string = "";
  while ($row = mysql_fetch_object($result)) {
  	$title          = stripslashes($row->title);
  	$linkurl        = stripslashes($row->link_url);
  	$filepath       = stripslashes($row->filepath);  	
    $summary        = $row->summary;
    $topic_idx      = $row->topic_id;
//    if ($topic_idx < 6) { // turn subtopics into main topic area
//      $topic_idx = "6";
//    }
  	$postdate       = format_datelong($row->post_date);
  	$pubdate        = format_datetimelong($row->post_date, $row->start_time);    	
    if ($row->expire_date != "0000-00-00") {
    	$enddate = format_datelong($row->expire_date);
    } else {
      $enddate = "Indefinite";
    }
  	$id             = $row->ID;
  	$description    = "Event date: " . $postdate;
    if ($enddate != $postdate) {
       $description .= " to " . $enddate;  
    }
    if ($row->start_time) {
      $page_starttime = time_convert($row->start_time, 1);      
      if ($page_starttime == "12:00 PM") {$page_starttime = "NOON";}
      if ($page_starttime == "12:00 AM") {$page_starttime = "MIDNIGHT";}
      $description .= " @ " . $page_starttime; 
    }         
      
  //      $description    = $description . " - " . trim(strip_tags($summary));
    $description    .= " - " . trim(convert_smart_quotes(htmlentities($summary, ENT_QUOTES, 'UTF-8')));
  	// Print out item
  	echo "<item>\n";
  	echo "  <pubDate>" . $pubdate . "</pubDate>\n";
  	echo "  <title>" . $title . "</title>\n";
  	if ($linkurl) {
  	  echo "  <link>" . $linkurl . "</link>\n";    	
  	} else {
  	  echo "  <link>" . $linkpath . $id . "</link>\n";
  	}
  	if ($topic_idx) {  	
     	echo "  <category><![CDATA[" . $topic[$topic_idx] . "]]></category>\n";
    }
  	echo "  <description>\n" . $description . "\n</description>\n"; 
    if ($filepath) {
      echo "  <enclosure url=\"$base_url$filepath\" length=\"" . filesize($base_path . $filepath)
        . "\" type=\"" . mime_content_type($base_path . $filepath) . "\" />\n";
    }    	
  	echo "</item>\n\n";		
  }
}
// Print RSS footer
echo "</channel>\n";
echo "</rss>\n";
?>
