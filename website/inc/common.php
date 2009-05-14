<?
// $Id: common.php,v 1.14 2003/06/23 21:27:08 chavan Exp $

/* Descrition:    Common functions (Website version)
 *                Uses variable from globals.php
 * 
 * List of functions:
 *   get_list()
 *   get_item()
 *   get_list_cal()
 *   get_list_cal_past()
 *   get_item_cal()
 */

/* FUNCTION: get_list
 * Get a list of active items
 * Usage: get_list($section_id, $weight, $topic_id, 
 *                 $liststart, $listlimit)
 *   $weight is the lowest level to display
 *     e.g. $weight = 2 will display items with
 *     weight >= 2. (Default is "2").
 */

function get_list($section_id = 0, $weight = 2, $topic_id = "",
      $liststart, $listlimit, $pageit = "", $older = "", 
      $greybox = "", $gbsize = "500, 300", $embed = "") {
    global $tbl_name;
    global $now_datetime;
    global $page_postdate;
    global $page_list;
    global $section_dir;
    global $base_path;
    global $base_url;  
    global $audio;
    
    $query = "SELECT ID, title, summary, post_date, link_url, filepath FROM $tbl_name 
	       WHERE status = 1
	       AND post_date <= '$now_datetime' 
	       AND weight <= '$weight'
	       AND section_id = '$section_id'
         ";
     if ($topic_id <> "") {
	     $query .= "AND (topic_id = $topic_id)
         ";
     }
	   $query .= "AND ( expire_date >= '$now_datetime' OR expire_date = '0000-00-00')";
 
    // Results pages navigator
    if ($listlimit) {
//      $countresult = "SELECT ID FROM $tbl_name 
//                        WHERE status = 1
//	                      AND section_id = '$section_id'
//	                      AND ( expire_date >= '$now_datetime' OR expire_date = '0000-00-00')
//                        ORDER BY post_date DESC";
      $countresult = mysql_query($query);
      $listcount = mysql_num_rows($countresult);
      if ($listcount > $listlimit) {
      	$listpages_num = $listcount/$listlimit;
      	$pagenavigator = "<p class=\"uip_listnav\">[ ";
      	if ($liststart > 0) {
      	  $pagenavigator .= "<a href=\"" . $REQUEST_URI 
      	    . "?start=" . ($liststart - $listlimit) 
      	    . "\">Previous</a> - ";
      	}
      	for ($i = 0; $i <= $listpages_num; $i++) {
      	  $listpagestart = $i * $listlimit;
      	  $listpage      = $i + 1;
      	  if ($i == ($liststart/$listlimit)) {
      	    $pagenavigator .= "<span class=\"uip_listpagenavlink\">" 
      	      . $listpage . "</span> ";	  
      	  } else { 
      	    $pagenavigator .= "<span class=\"uip_listnavlink\"><a href=\"" 
      	      . $REQUEST_URI 
      	      . "?start=" . $listpagestart . "\">" 
      	      . $listpage . "</a></span> ";
      	  }
      	}
      	if ($liststart < ($listcount - $listlimit)) {
      	  $pagenavigator .= " - <a href=\"" . $REQUEST_URI . "?section_id=" 
      	    . $section_id . "&amp;start=" . ($liststart + $listlimit) 
      	    . "\">Next</a> ";
      	}
      	$pagenavigator .= "]</p>\n";
      }
    }

	  $query .= " ORDER BY post_date DESC";
	  $olderquery = $query;
    if ($liststart) {
      $query .= " LIMIT $liststart, $listlimit";
    } else if ($listlimit > 0 ) {
      $query .= " LIMIT $listlimit";
    }
 
    $result = mysql_query($query);    
    while ($row = mysql_fetch_object($result)) {
    	$title          = stripslashes($row->title);
      $summary        = stripslashes($row->summary);
    	$page_postdate  = $row->post_date;
    	$id             = $row->ID;
      $linkurl        = stripslashes($row->link_url);
    	// Set date format for list
    	$page_postdate  = format_datelong($page_postdate);
      if (($listlimit == "") or ($listlimit > 1)) { 
    	    $string .= "<b>" . $page_postdate . "</b><br>";
        }
    	$string .= "<strong><a href=\"";
      if ($linkurl) {
    	    $string .= $linkurl;
      } else {
    	    if ($section_dir[$section_id] != "") { 
    	       $string .= $section_dir[$section_id] . "/";
    	    }
    	    $string .= "item.php?id=" . $id;
      }
      $string .= "\"";
      if ($greybox) {
        $string .= " title=\"" . $greybox . "\" rel=\"gb_page_center[$gbsize]\"";
      }
    	$string .= ">" . $title . "</a>" 
    	                  . "</strong> - " . $summary . "<br>";
      if ($row->filepath) {
	        $filepath = $base_path . "/" . $row->filepath;
	        if (file_exists($filepath)) {
      		    if ($file=fopen($filepath, "r")) {    	                  
                	if ($embed && $audio && (strtolower(end(explode( '.', $filepath ))) == "mp3")) {
                    $string .=  "<p id=\"audioplayer_$id\">$row->filepath</p>"  
                                . "<script type=\"text/javascript\">"  
                                . "AudioPlayer.embed(\"audioplayer_$id\", {soundFile: \"$base_url$row->filepath\"});"   
                                . "</script><br>";          
                  }
              }
          }
      }
      $string .= "<br> \n";
    }
    if ($older && ($listcount > ($liststart + $listlimit))) {
      $string .= "<b>" . $older . "</b><br>";
      $olderquery .= " LIMIT " . ($liststart + $listlimit) . ", $listlimit";
      $olderresult = mysql_query($olderquery);    
      while ($row = mysql_fetch_object($olderresult)) {
      	$title          = stripslashes($row->title);
      	$id             = $row->ID;
        $linkurl        = stripslashes($row->link_url);
      	$string .= "- <a href=\"";
        if ($linkurl) {
      	    $string .= $linkurl;
        } else {
      	    if ($section_dir[$section_id] != "") { 
      	       $string .= $section_dir[$section_id] . "/";
      	    }
      	    $string .= "item.php?id=" . $id;
        }
        $string .= "\"";
        if ($greybox) {
          $string .= " title=\"" . $greybox . "\" rel=\"gb_page_center[$gbsize]\"";
        }
      	$string .= ">" . $title . "</a><br>\n";
      }   
      $string .= "<br>";   
    }
    
    if ($pageit) {
        $string .= $pagenavigator;
    }
    $page_list = $string . "";
    if ($page_list == "") {
        $page_list = "NONE AVAILABLE!";
    }
}

/* FUNCTION: get_item
 * Get information for the specified item and set variables
 * Usage: get_item($id)
 */
 
function get_item($id, $embed = "") {
    global $tbl_name;
    global $now_datetime;
    global $page_postdate;
    global $page_summary;
    global $page_content;
    global $page_title;
    global $page_linktitle;
    global $page_linkurl;
    global $page_link;
    global $page_file;
    global $base_path;
    global $base_url;    
    global $audio;
    if ($id == "") {
	echo display_err("No ID.");
    } else {
	$query = "SELECT * FROM $tbl_name
		   WHERE ID = $id 
		   AND status = 1
		   AND (expire_date >= '$now_datetime' OR expire_date = '0000-00-00')";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	if (!$row) {
	    echo display_err("Couldn't find that page.");
	    exit();
	} else {   
	    $page_title      = stripslashes($row->title);
	    $page_summary    = stripslashes($row->summary);
	    $page_content    = nl2br(url_to_htmllink(stripslashes($row->content)));
	    $page_linktitle  = stripslashes($row->link_title);
	    $page_linkurl    = stripslashes($row->link_url);
	    $page_postdate   = stripslashes($row->post_date);
	    // Attached File
      if ($row->filepath) {
	        $filepath    = $base_path . "/" . $row->filepath;
	        if (file_exists($filepath)) {
      		    if (!$file=fopen($filepath, "r")) {
      		        $page_file = "<!-- Couldn't Find Attached  File -->";
      		    } else {
//              	  $ftype = strtolower(end( explode( '.', $filepath )));
//                  if ($ftype = "txt" or $ftype = "htm" or $ftype = "html") {
//          		        $page_file = file("$filepath");
//          		        $page_file = implode(" ", $page_file);
//       		        } else {
                if ($embed && $audio && (strtolower(end(explode( '.', $filepath ))) == "mp3")) {
          		    $page_file = "<p id=\"audioplayer_$id\">$row->filepath</p>"  
                    . "<script type=\"text/javascript\">"  
                    . "AudioPlayer.embed(\"audioplayer_$id\", {soundFile: \"$base_url$row->filepath\"});"   
                    . "</script>";                       
                } else {
          		    $page_file = "Attachment: <a href=\""
          		      . $base_url . $row->filepath 
          		      . "\">" . $row->filepath 
          		      . "</a>" ;    
                    }   		        
//       		        }
      		    }
	        } else {
		          $page_file       = "<!-- Couldn't Find Attached File -->";
	        }
      }
	    // set date format for item
	    $page_postdate = format_datelong($page_postdate);
	    if ($page_linkurl) {
    		if ($page_linktitle) {		    
    		    $page_link =  "Link: <a href=\""
    		      . $page_linkurl 
    		      . "\">" 
    		      . $page_linktitle
    		      . "</a>" ;
    		} else {
    		    $page_link = "Link: <a href=\""
    		      . $page_linkurl 
    		      . "\">" . $page_linkurl 
    		      . "</a>" ;
    		}
	    }	}
    }
}

/* FUNCTION: get_list_cal
 * Get a list of active items
 * Usage: get_list_cal($section_id, $weight)
 *   $weight is the lowest level to display
 *     e.g. $weight = 2 will display items with
 *     weight >= 2. (Default is "2").
 */

function get_list_cal($section_id = 0, $weight = 2, $topic_id = "", 
      $liststart, $listlimit, $pageit = "", $greybox = "", $gbsize = "500, 300") {
    global $tbl_name_cal;
    global $now_datetime;
    global $page_postdate;
    global $page_starttime;
    global $page_enddate;
    global $page_list_cal;
    global $section_dir_cal;
    $query = "SELECT ID, title, summary, post_date, start_time, expire_date FROM $tbl_name_cal 
	       WHERE status = 1
	       AND weight <= '$weight'
	       AND section_id = '$section_id'";
     if ($topic_id <> "") {
	     $query .= "AND (topic_id = $topic_id)
         ";
     }
	   $query .= "AND ( expire_date >= '$now_datetime' OR expire_date = '0000-00-00')
		 ORDER BY post_date 
	       ";
	       
    // Results pages navigator
    if ($listlimit) {
//      $countresult = "SELECT ID FROM $tbl_name 
//                        WHERE status = 1
//	                      AND section_id = '$section_id'
//	                      AND ( expire_date >= '$now_datetime' OR expire_date = '0000-00-00')
//                        ORDER BY post_date DESC";
      $countresult = mysql_query($query);
      $listcount = mysql_num_rows($countresult);
      if ($listcount > $listlimit) {
      	$listpages_num = $listcount/$listlimit;
      	$pagenavigator = "<p class=\"uip_listnav\">[ ";
      	if ($liststart > 0) {
      	  $pagenavigator .= "<a href=\"" . $REQUEST_URI 
      	    . "?start=" . ($liststart - $listlimit) 
      	    . "\">Previous</a> - ";
      	}
      	for ($i = 0; $i <= $listpages_num; $i++) {
      	  $listpagestart = $i * $listlimit;
      	  $listpage      = $i + 1;
      	  if ($i == ($liststart/$listlimit)) {
      	    $pagenavigator .= "<span class=\"uip_listpagenavlink\">" 
      	      . $listpage . "</span> ";	  
      	  } else { 
      	    $pagenavigator .= "<span class=\"uip_listnavlink\"><a href=\"" 
      	      . $REQUEST_URI 
      	      . "?start=" . $listpagestart . "\">" 
      	      . $listpage . "</a></span> ";
      	  }
      	}
      	if ($liststart < ($listcount - $listlimit)) {
      	  $pagenavigator .= " - <a href=\"" . $REQUEST_URI . "?section_id=" 
      	    . $section_id . "&amp;start=" . ($liststart + $listlimit) 
      	    . "\">Next</a> ";
      	}
      	$pagenavigator .= "]</p>\n";
      }
    }
	       
    if ($liststart) {
      $query .= " LIMIT $liststart, $listlimit";
    } else if ($listlimit > 0 ) {
      $query .= " LIMIT $listlimit";
    }
    
    $result = mysql_query($query); 
    $string = "";
    while ($row = mysql_fetch_object($result)) {
    	$title          = stripslashes($row->title);
      $summary        = stripslashes($row->summary);
    	$page_postdate  = $row->post_date;
    	$page_starttime = time_convert($row->start_time, 1);
    	$page_enddate   = $row->expire_date;
    	$id             = $row->ID;
    
    	// Set date format for list
    	$page_postdate  = format_datelong($page_postdate);
      if ($page_enddate != "0000-00-00") {
      	$page_enddate = format_datelong($page_enddate);
      } else {
        $page_enddate = "Indefinite";
      }
    	$string .= "<b>" . $page_postdate . "</b>";
      if ($page_postdate != $page_enddate) {
    	   $string .= "<b> to " . $page_enddate . "</b>";  
      }
      if ($page_starttime) { 
        if ($page_starttime == "12:00 PM") {$page_starttime = "NOON";}
        if ($page_starttime == "12:00 AM") {$page_starttime = "MIDNIGHT";}
        $string .= " @ " . $page_starttime; 
        }      
    	$string .= "<br><strong><a href=\"";
      if ($linkurl) {
    	    $string .= $linkurl;
      } else {
    	    if ($section_dir_cal[$section_id] != "") { 
    	       $string .= $section_dir_cal[$section_id] . "/";
    	    }
    	    $string .= "item.php?id=" . $id;
      }
      $string .= "\"";
      if ($greybox != "") {
        $string .= " title=\"" . $greybox . "\" rel=\"gb_page_center[$gbsize]\"";
      }
      $string .= ">" . $title . "</a>" 
              . "</strong> - " . $summary . "<br><br> \n";
    }
    if ($pageit) {
        $string .= $pagenavigator;
    }
    $page_list_cal = $string . "";
    if ($page_list_cal == "") {
        $page_list_cal = "NOTHING SCHEDULED!";
    }
}

/* FUNCTION: get_list_cal_past
 * Get a list of past/expired event items
 * Usage: get_list_cal_past($section_id, $weight)
 *   $weight is the lowest level to display
 *     e.g. $weight = 2 will display items with
 *     weight >= 2. (Default is "2").
 */

function get_list_cal_past($section_id = 0, $weight = 2, $topic_id = "", 
      $liststart, $listlimit, $pageit = "", $greybox = "", $gbsize = "500, 300") {
    global $tbl_name_cal;
    global $now_datetime;
    global $page_postdate;
    global $page_starttime;
    global $page_enddate;
    global $page_list_cal_past;
    global $section_dir_cal;
    $query = "SELECT ID, title, summary, post_date, start_time, expire_date FROM $tbl_name_cal 
	       WHERE status = 1
	       AND weight <= '$weight'
	       AND section_id = '$section_id'";
     if ($topic_id <> "") {
	     $query .= "AND (topic_id = $topic_id)
         ";
     }
	   $query .= "AND ( expire_date < '$now_datetime')
		 ORDER BY post_date DESC
	       ";
	       
    // Results pages navigator
    if ($listlimit) {
//      $countresult = "SELECT ID FROM $tbl_name 
//                        WHERE status = 1
//	                      AND section_id = '$section_id'
//	                      AND ( expire_date >= '$now_datetime' OR expire_date = '0000-00-00')
//                        ORDER BY post_date DESC";
      $countresult = mysql_query($query);
      $listcount = mysql_num_rows($countresult);
      if ($listcount > $listlimit) {
      	$listpages_num = $listcount/$listlimit;
      	$pagenavigator = "<p class=\"uip_listnav\">[ ";
      	if ($liststart > 0) {
      	  $pagenavigator .= "<a href=\"" . $REQUEST_URI 
      	    . "?start=" . ($liststart - $listlimit) 
      	    . "\">Previous</a> - ";
      	}
      	for ($i = 0; $i <= $listpages_num; $i++) {
      	  $listpagestart = $i * $listlimit;
      	  $listpage      = $i + 1;
      	  if ($i == ($liststart/$listlimit)) {
      	    $pagenavigator .= "<span class=\"uip_listpagenavlink\">" 
      	      . $listpage . "</span> ";	  
      	  } else { 
      	    $pagenavigator .= "<span class=\"uip_listnavlink\"><a href=\"" 
      	      . $REQUEST_URI 
      	      . "?start=" . $listpagestart . "\">" 
      	      . $listpage . "</a></span> ";
      	  }
      	}
      	if ($liststart < ($listcount - $listlimit)) {
      	  $pagenavigator .= " - <a href=\"" . $REQUEST_URI . "?section_id=" 
      	    . $section_id . "&amp;start=" . ($liststart + $listlimit) 
      	    . "\">Next</a> ";
      	}
      	$pagenavigator .= "]</p>\n";
      }
    }
	       
    if ($liststart) {
      $query .= " LIMIT $liststart, $listlimit";
    } else if ($listlimit > 0 ) {
      $query .= " LIMIT $listlimit";
    }
    
    $result = mysql_query($query); 
    $string = "";
    while ($row = mysql_fetch_object($result)) {
    	$title          = stripslashes($row->title);
      $summary        = stripslashes($row->summary);
    	$page_postdate  = $row->post_date;
    	$page_starttime = time_convert($row->start_time, 1);
    	$page_enddate   = $row->expire_date;
    	$id             = $row->ID;
    
    	// Set date format for list
    	$page_postdate  = format_datelong($page_postdate);
      if ($page_enddate != "0000-00-00") {
      	$page_enddate = format_datelong($page_enddate);
      } else {
        $page_enddate = "Indefinite";
      }
    	$string .= "<b>" . $page_postdate . "</b>";
      if ($page_postdate != $page_enddate) {
    	   $string .= "<b> to " . $page_enddate . "</b>";  
      }
      if ($page_starttime) { 
        if ($page_starttime == "12:00 PM") {$page_starttime = "NOON";}
        if ($page_starttime == "12:00 AM") {$page_starttime = "MIDNIGHT";}
        $string .= " @ " . $page_starttime; 
        }   
    	$string .= "<br><strong><a href=\"";
      if ($linkurl) {
    	    $string .= $linkurl;
      } else {
    	    if ($section_dir_cal[$section_id] != "") { 
    	       $string .= $section_dir_cal[$section_id] . "/";
    	    }
    	    $string .= "item.php?id=" . $id;
      }
      $string .= "\"";
      if ($greybox != "") {
        $string .= " title=\"" . $greybox . "\" rel=\"gb_page_center[$gbsize]\"";
      }
      $string .= ">" . $title . "</a>" 
              . "</strong> - " . $summary . "<br><br> \n";
    }
    if ($pageit) {
        $string .= $pagenavigator;
    } 
    $page_list_cal_past = $string . "";
    if ($page_list_cal_past == "") {
        $page_list_cal_past = "NO PAST EVENTS!";
    }
}

/* FUNCTION: get_item_cal
 * Get information for the specified item and set variables
 * Usage: get_item_cal($id)
 */
 
function get_item_cal($id) {
    global $tbl_name_cal;
    global $now_datetime;
    global $page_postdate;
    global $page_starttime;
    global $page_enddate;
    global $page_summary;
    global $page_content;
    global $page_title;
    global $page_linktitle;
    global $page_linkurl;
    global $page_link;
    global $page_file;
    global $base_path;
    global $base_url;
    if ($id == "") {
	echo display_err("No ID.");
    } else {
	$query = "SELECT * FROM $tbl_name_cal
		   WHERE ID = $id 
		   AND status = 1";
//		   AND (expire_date >= '$now_datetime' OR expire_date = '')";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	if (!$row) {
	    echo display_err("Couldn't find that page.");
	    exit();
	} else {   
	    $page_title      = stripslashes($row->title);
	    $page_summary    = stripslashes($row->summary);
	    $page_content    = nl2br(url_to_htmllink(stripslashes($row->content)));
	    $page_linktitle  = stripslashes($row->link_title);
	    $page_linkurl    = stripslashes($row->link_url);
	    $page_postdate   = stripslashes($row->post_date);
	    $page_starttime  = time_convert(stripslashes($row->start_time), 1);	    
	    $page_enddate    = stripslashes($row->expire_date);
	    // Include File
      if ($row->filepath) {
	        $filepath        = $base_path . "/" . $row->filepath;
	        if (file_exists($filepath)) {
      		    if (!$file=fopen($filepath, "r")) {
      		        $page_file = "<!-- Couldn't Find Attached File -->";
      		    } else {  
//              	  $ftype = strtolower(end( explode( '.', $filepath )) );
//                  if ($ftype = "txt" or $ftype = "htm" or $ftype = "html") {
//          		        $page_file = file("$filepath");
//          		        $page_file = implode(" ", $page_file);
//       		        } else {
              		    $page_file = "Attachment: <a href=\""
              		      . $base_url . "/" . $row->filepath 
              		      . "\">" . $row->filepath 
              		      . "</a>" ; 
//                  }      		        
      		    }
	        } else {
		          $page_file       = "<!-- Couldn't Find Attached File -->";
	        }
      }
	    // set date format for item
	    $page_postdate   = format_datelong($page_postdate);
      if ($page_enddate != "0000-00-00") {
      	$page_enddate = format_datelong($page_enddate);
      } else {
        $page_enddate = "Indefinite";
      }
      if ($page_postdate != $page_enddate) {
    	   $page_postdate = $page_postdate . " to " . $page_enddate;  
      }
      if ($page_starttime) { 
        if ($page_starttime == "12:00 PM") {$page_starttime = "NOON";}
        if ($page_starttime == "12:00 AM") {$page_starttime = "MIDNIGHT";}
        $page_postdate .= " @ " . $page_starttime; 
      }
	    if ($page_linkurl) {
    		if ($page_linktitle) {		    
    		    $page_link =  "Link: <a href=\""
    		      . $page_linkurl 
    		      . "\">" 
    		      . $page_linktitle
    		      . "</a>" ;
    		} else {
    		    $page_link = "Link: <a href=\""
    		      . $page_linkurl 
    		      . "\">" . $page_linkurl 
    		      . "</a>" ;
    		}
	    }
	}
    }
}

/* FUNCTION: url_to_htmllink
 * Change a url in text to HTML link
 */

function url_to_htmllink($text) {
  $newtext = eregi_replace("([^=.'\"])http://([^ \n\r]*)", "\\1<a href=\"http://\\2\">\\2</a>", $text);
  return $newtext;
}

function convert_smart_quotes($string) {
     $search = array(chr(145),
                     chr(146),
                     chr(147),
                     chr(148),
                     chr(150),
                     chr(151));
     $replace = array("'",
                      "'",
                      '"',
                      '"',
                      '-',
                      '-');
     return str_replace($search, $replace, $string); } 
?>
