<?php
// $Id: js.php,v 1.1 2003/04/15 03:15:41 chavan Exp $
//
/* Displays a Javascript version  of this section's list
 * Using a snippet of Javascript code, this list can be 
 * displayed on another page or even another website for
 * for syndication. Here is the suggested Javascript:
   
   <!-- Your Website Name -->
   <script type="text/javascript" src="http://www.yourwebsite.com/uical_section/js.php">
   </script>
   <noscript><a href="http://www.yourwebsite.com/">
   Your Website Name</a></noscript>
 
 *
 */
require ("../inc/config.php");
require ("../inc/globals.php");
require ("../inc/common.php");
require ("../inc/connect_db.php");
require ("../inc/display_err.php");
require ("../inc/format_date.php");
require ("section_id.php");

// Configuration
// $sectiondir is the name of the directory/path where this 
// FIle is located
//$sectiondir     = "/events";
// You can leave these as they are or customize them as needed.
$creditlinkname = $base_websitename;
$creditlinkurl  = $base_url;
 
// Link path Example: news/item.php?id=
$linkpath         = $base_url . $section_dir_cal[$section_id] . "/item.php?id=";
if ( connect_db() == "failed") {
  echo Ffrmt_error("Unable to connect to the database.");
} else {
  // Print channel information
  echo "document.writeln(\"<p>\"); \n";
  $query = "SELECT ID, title, post_date FROM $tbl_name_cal
       WHERE status = 1
       AND post_date >= '$now_datetime' 
       AND section_id = '$section_id'
       AND ( expire_date > '$now_datetime' OR expire_date = '')
       ORDER BY post_date LIMIT 10
       ";  
  $result = mysql_query($query); 
  $string = "";
  while ($row = mysql_fetch_object($result)) {
    $title          = stripslashes($row->title);
    $postdate       = format_dateshort($row->post_date);
    $id             = $row->ID;
    // Print out item
    echo "document.writeln(\""  
              . $postdate . ": <a href='" . $linkpath  
            . $id . "'>" . $title . "</a>"
      . "<br>\"); \n";
  }
  echo "document.writeln(\"<em>Source: <a href='" 
    . $creditlinkurl .  "'>" . $creditlinkname . "</a></em>\"); \n";
  echo "document.writeln(\"</p>\"); \n";
}
?>
