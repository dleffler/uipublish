<?
// $Id: common.php,v 1.12 2003/09/22 13:15:29 chavan Exp $


/* Description:   Common functions (Admin Version)
 *                Uses variables from globals.php
 * 
 * List of functions:
 *   get_adminlist()
 *   get_adminitem()
 *   get_item()
 *   delete_item()
 *   get_adminlist_cal()
 *   get_adminitem_cal()
 *   get_item_cal()
 *   delete_item_cal()
 *   filter_html()
 *   navbar() 
 */

/* FUNCTION: get_adminlist
 * Get a list of items (Admin Version)
 * Usage: get_adminlist(section_id)
 */

function get_adminlist($section_id = "", $liststart, $listlimit, $srchqry = "", $draft = "", $sort = "") {
    global $tbl_name;
    global $now_datetime;
    global $page_postdate;
    global $page_list;
    global $topic;
    global $section_dir;
    
    // Set Table Cell Colors
    $cellcol_on  = "<td align = right bgcolor=\"#99ff33\">";
    $cellcol_off = "<td align = right bgcolor=\"#cccc99\">";
    $cellcol_err = "<td align = right bgcolor=\"#ff6600\">";
    $col_online  = "bgcolor=\"#ffff66\"";
    $col_offline = "bgcolor=\"#ffffcc\"";

    // Results pages navigator
    $query_listcount = "SELECT ID FROM $tbl_name";
    if ($section_id != "") {
      $query_listcount .= " WHERE section_id = '$section_id'";
      if ($srchqry || $draft){
        $query_listcount .= " AND ";
      } 
    }
    if ($srchqry){
      if ($section_id == "") {
        $query_listcount .= " WHERE ";
      }
      $query_listcount .= "(title LIKE '%".$srchqry."%'" .
    	  	" OR summary LIKE '%".$srchqry."%')";
    }                    
    if ($draft){
      if (($section_id == "") && ($srchqry == "")) {
        $query_listcount .= " WHERE ";
      }
      $query_listcount .= "status = '2'";
    }                    
    $query_listcount_result = mysql_query($query_listcount);
    $listcount              = mysql_num_rows($query_listcount_result);
    $pagenavigator = "<p class=\"uip_listpagenav\">Total Items: <strong>" 
	      . $listcount . "</strong>";
    if ($section_id != ""){
      $tag = "&amp;section_id=" . $section_id;
    }
    if ($srchqry){
      $tag .= "&amp;search=" . $srchqry;
    } 
    if ($draft){
      $tag .= "&amp;draft=1";
    }    
    if ($listcount > $listlimit) {
      $listpages_num = $listcount/$listlimit;
      $pagenavigator .= " - Pages: ";
      for ($i = 0; $i <= $listpages_num; $i++) {
      	$listpagestart = $i * $listlimit;
      	$listpage      = $i + 1;
      	if ($i == ($liststart/$listlimit)) {
      	  $pagenavigator .= "<span class=\"uip_listpagenavlink\">" . $listpage . "</span> ";	  
      	} else { 
      	  $pagenavigator .= "<span class=\"uip_listpagenavlink\"><a href=\"list.php?";
          $pagenavigator .= "start=" . $listpagestart;
          if ($sort){
            $pagenavigator .= "&amp;sort=" . $sort;
          }                    
          $pagenavigator .= $tag . "\">" . $listpage . "</a></span> ";
      	}
      }
    }
    $pagenavigator .= "</p>\n";
    $string = $pagenavigator;	  
    if ($liststart) {
      $tag .= "&amp;start=" . $liststart;
    }    
    $query = "SELECT ID, title, post_date, status, 
	       expire_date, weight, topic_id, section_id
	      FROM $tbl_name";
    if ($section_id != "") {
      $query .= " WHERE section_id = '$section_id'";
      if ($srchqry || $draft){
        $query .= " AND ";
      } 
    }
    if ($srchqry){
      if ($section_id == "") {
        $query .= " WHERE ";
      }
      $query .= "(title LIKE '%".$srchqry."%'" .
    	  	" OR summary LIKE '%".$srchqry."%')";
    }                    
    if ($draft){
      if (($section_id == "") && ($srchqry == "")) {
        $query .= " WHERE ";
      }
      $query .= "status = '2'";
    }   	
		if ($sort) {
			$sort = split("/",$sort);
			//decide what to inverse
			$sort_r = ($sort[1] == 'desc') ? "asc" : "desc";
		} else { //else default sorting/column
			$sort[0] = 'post_date';
			$sort[1] = 'desc';
			$sort_r = "desc";				
		}    
		$query .= " ORDER BY ".$sort[0]." ".$sort[1];
    if ($liststart) {
      $query .= " LIMIT $liststart, $listlimit";
    } else {
      $query .= " LIMIT $listlimit";
    }
    $result = mysql_query($query); 
    
    // Set up table and legend    
    $string .= "<table bgcolor=\"#cccccc\" border=\"0\"
		cellspacing=\"2\" cellpadding=\"2\"> \n	<tr>"
                . "<td bgcolor=\"#cccccc\"><a title=\"Preview this Section\" href=\"" . $section_dir[$section_id] . "/index.php \" target=\"_blank\">Preview this Section</a></td>"		
                . "<td><font size=-2> - Legend:</font></td>" 
                . "<td " . $col_online 
                . "><font size=-2>Item Online</font></td>"
                . "<td " . $col_offline 
                . "><font size=-2>Item Offline</font></td>"
                . "</tr></table>"
                . "<table bgcolor=\"#cccccc\" border=\"0\" 
		    cellspacing=\"0\" cellpadding=\"0\">
		    <tr><td bgcolor=\"#cccccc\"> \n"
                . "<table bgcolor=\"#cccccc\" border=\"0\" 
		cellspacing=\"2\" cellpadding=\"2\"> \n
		<tr bgcolor=\"#999999\">
		<td color=\"#cccccc\"><a title=\"Add a new article item\" href=\"add.php";
    if ($section_id != "") {
	    $string .= "?section_id=" . $section_id;
    }
    $string .= "\"  class=\"button\"\">Add</a></td>		
		<td><font size=\"-1\"><strong>ID</strong></font></td>
		<td><font size=\"-1\">Title</font></td>
		<td><font size=\"-1\"><a title=\"Sort by Category\" href=\"list.php?" . $tag . "&amp;sort=topic_id/" . $sort_r . "\">Category</font></td>
		<td><font size=\"-1\">Live</font></td>
		<td><font size=\"-1\"><a title=\"Sort by Publishing Status\" href=\"list.php?" . $tag . "&amp;sort=status/" . $sort_r . "\">Post</font></td>
		<td><font size=\"-1\"><a title=\"Sort by Publishing Date\" href=\"list.php?" . $tag . "&amp;sort=post_date/" . $sort_r . "\">Post Date</font></td>
		<td><font size=\"-1\"><a title=\"Sort by Expiration Date\" href=\"list.php?" . $tag . "&amp;sort=expire_date/" . $sort_r . "\">Expire Date</font></td>
		<td><font size=\"-1\"><a title=\"Sort by Priority\" href=\"list.php?" . $tag . "&amp;sort=weight/" . $sort_r . "\">Front Page</font></td>
		<td>&nbsp;</th>
		</tr>";
 
    while ($row = mysql_fetch_object($result)) {
    	$title          = stripslashes($row->title);
      $topic_idx      = $row->topic_id;
    	$post_date      = $row->post_date;
    	$id             = $row->ID;
    	$weight         = $row->weight;
    	$expire_date    = $row->expire_date;
    	$status         = $row->status;	
    	$tablerow_prn = "<tr>";
    	
    	$title = "<a title=\"Preview this Item\" href=\"" . $section_dir[$section_id] . "/item.php?id=" . $id . "\" target=\"_blank\">" . $title . "</a>";
    	// Create color-coded table cell for Status (Post)
    	switch ($status) {
    	 case "1":
    	    $status_prn = $cellcol_on 
    	      . "<font size=\"-2\">Publish</font></td>";
    	    $publish_switch = "on";
    	    break;
    	 case "2":
    	    $status_prn = $cellcol_off 
    	      . "<font size=\"-2\">Draft</font></td>";
    	    $publish_switch = "off";
    	    break;
    	 default: 
    	    $status_prn = $cellcol_err 
    	      . "<font size=\"-2\">Unknown</font></td>";
    	    $publish_switch = "off";
    	}
    		
    	// Create color coded table cell color for Weight (Front Page)
    	switch ($weight) {
    	 case "1":
    	    $weight_prn = "<td bgcolor=\"ooccff\">
    			    <font size=\"-2\">Yes</font></td>";
    	    break;
    	 case "2":
    	    $weight_prn = "<td bgcolor=\"#00ffff\">
    			    <font size=\"-2\">No</font></td>";
    	    break;   
    	 default: 
    	    $weight_prn = "<td><font size=\"-2\">Unknown</font></td>";
    	}
    	
    	// Create color coded table cell for Post date
    	if ($post_date <= substr($now_datetime, 0, 10)) {
    	    $post_date_prn = $cellcol_on . "<font size=\"-2\">" 
    	      . format_datelong($post_date) . "</font></td>";
    	} else {
    	    $post_date_prn = $cellcol_off . "<font size=\"-2\">" 
    	      . format_datelong($post_date) . "</font></td>";
    	    $publish_switch = "off";
    	}
    	
    	// Create color coded table cell for Expire date
    	if ($expire_date >= substr($now_datetime, 0, 10)) {
    	    $expire_date_prn = $cellcol_on . "<font size=\"-2\">" 
    	      . format_datelong($expire_date) . "</font></td>";
    	} else {
    	    if ($expire_date == "0000-00-00") {
    		$expire_date_prn = $cellcol_on 
    		  . "<font size=\"-2\">No date</font></td>";
    	    } else {
    		$expire_date_prn = $cellcol_off . "<font size=\"-2\">" 
    		  . format_datelong($expire_date) . "</font></td>";
    		$publish_switch = "off";
    	    }
    	}
    	
    	//  Create  color coded table cell for Publish and 
    	// Table Row  Color
    	switch ($publish_switch) {
    	 case "on":
    	    $publish_prn = "<td><font size=\"-2\">Online</font></td>";
    	    $tablerow_prn = "<tr " . $col_online . ">";
    	    break;
    	 default:
    	    $publish_prn = "<td><font size=\"-2\">Offline</font></td>";
    	    $tablerow_prn = "<tr " . $col_offline . ">";
    	    break;
    	}
    	
    	// Print out Table Rows		
    	$string .= $tablerow_prn
          . "<td><a title=\"Edit this item\" href=\"mod.php?id=" 
          . $id . "\" class=\"button\">Edit</a></td>"
          . "<td align=right><font size=-2>" 
          . $id . "</font></td><td>" 
          . $title . "</a></td><td><font size=-2>"
          . $topic[$topic_idx] . "</font></td>"
          . $publish_prn . $status_prn
          . $post_date_prn . $expire_date_prn 
          . $weight_prn 
          . "<td><a title=\"Delete this item\" href=\"confirm.php?id=" 
          . $id . "\" class=\"button\">Delete</a></td></tr> \n";
    }
    $page_list = $string . "</table></td></tr></table>\n" . $pagenavigator ;
}

/* FUNCTION: get_adminitem
 * Get information for the specified item and set variables
 * Usage: get_item($id)
 * 
 * CAUTION: This function sets global variables that may
 * conflict the ones you are using. This function is written 
 * for the mod.php file. 
 */
 
function get_adminitem($id) {
    global $tbl_name;
    global $now_datetime;
    global $post_date;
    global $expire_date;
    global $status;
    global $weight;
    global $title;    
    global $summary;
    global $content;
    global $link_title;
    global $link_url;
    global $filepath;
    global $topic_id;
    global $section_id;
    
    if ($id == "") {
	echo display_err("No ID.");
    } else {
	$query = "SELECT * FROM $tbl_name
		   WHERE ID = $id 
		   ";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	if (!$row) {
	    echo display_err("Couldn't find that page.");
	    exit();
	} else {   	    
	    $post_date   = $row->post_date;
	    $expire_date = $row->expire_date;
	    $status     = $row->status;
	    $weight     = $row->weight;
	    $title      = $row->title;
	    $summary    = $row->summary;
	    $content    = $row->content;
	    $link_title = $row->link_title;
	    $link_url   = $row->link_url;
	    $filepath   = $row->filepath;
	    $topic_id   = $row->topic_id;
	    $section_id = $row->section_id;
	}
    }
}

/* FUNCTION: get_item
 * Get information for the specified item and set variables
 * Usage: get_item($id)
 */
 
function get_item($id) {
    global $tbl_name;
    global $now_datetime;
    global $page_postdate;
    global $page_summary;
    global $page_content;
    global $page_title;
    global $page_linktitle;
    global $page_linkurl;
    global $page_link;
    if ($id == "") {
	echo display_err("No ID.");
    } else {
	$query = "SELECT * FROM $tbl_name
		   WHERE ID = $id";
	  
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	if (!$row) {
	    echo display_err("Couldn't find that page.");
	    exit();
	} else {   
	    $page_title      = stripslashes($row->title);
	    $page_summary    = stripslashes($row->summary);
	    $page_content    = stripslashes($row->content);
	    $page_linktitle  = stripslashes($row->link_title);
	    $page_linkurl    = stripslashes($row->link_url);
	    $page_postdate   = stripslashes($row->post_date);
	    // set date format for item
	    $page_postdate   = format_datelong($page_postdate);
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

/* FUNCTION: delete_item
 * Delete the item
 * Usage: delete_item($id)
 */

function delete_item($id) {
    global $tbl_name;
    $query = "DELETE FROM $tbl_name WHERE ID = $id";    
    $result = mysql_query($query);
    if ($result) {
	    echo("<p><strong>Successful!</strong> 
		   Go back to the <a href=\"index.php\">Manage Articles</a> 
		   page.</p>");
    }
}

// CALENDAR FUNCTIONS

/* FUNCTION: get_adminlist_cal
 * Get a list of calendar items (Admin Version)
 * Usage: get_adminlist_cal(section_id)
 */

function get_adminlist_cal($section_id = "", $liststart, $listlimit, $srchqry = "", $draft = "", $sort = "") {
    global $tbl_name_cal;
    global $now_datetime;
    global $page_postdate_cal;
    global $page_list_cal;
    global $topic;
    global $section_dir_cal;    

    // Set Table Cell Colors
    $cellcol_on  = "<td align=right bgcolor=\"#99ff33\">";
    $cellcol_now  = "<td align=right bgcolor=\"#ccff99\">";
    $cellcol_off = "<td align =right bgcolor=\"#cccc99\">";
    $cellcol_err = "<td align = right bgcolor=\"#ff6600\">";
    $col_online  = "bgcolor=\"#ffff66\"";
    $col_offline = "bgcolor=\"#ffffcc\"";
    
    // Results pages navigator
    $query_listcount = "SELECT ID FROM $tbl_name_cal";
    if ($section_id != "") {
      $query_listcount .= " WHERE section_id = '$section_id'";
      if ($srchqry || $draft){
        $query_listcount .= " AND ";
      } 
    }
    if ($srchqry){
      if ($section_id == "") {
        $query_listcount .= " WHERE ";
      }
      $query_listcount .= "(title LIKE '%".$srchqry."%'" .
    	  	" OR summary LIKE '%".$srchqry."%')";
    }                    
    if ($draft){
      if (($section_id == "") && ($srchqry == "")) {
        $query_listcount .= " WHERE ";
      }
      $query_listcount .= "status = '2'";
    }   
    $query_listcount_result = mysql_query($query_listcount);
    $listcount              = mysql_num_rows($query_listcount_result);
    $pagenavigator = "<p class=\"uip_listpagenav\">Total Items: <strong>" 
	      . $listcount . "</strong>";
    if ($section_id != ""){
      $tag = "&amp;section_id=" . $section_id;
    }
    if ($srchqry){
      $tag .= "&amp;search=" . $srchqry;
    } 
    if ($draft){
      $tag .= "&amp;draft=1";
    }    	      
    if ($listcount > $listlimit) {
      $listpages_num = $listcount/$listlimit;
      $pagenavigator .= " - Pages: ";
      for ($i = 0; $i <= $listpages_num; $i++) {
      	$listpagestart = $i * $listlimit;
      	$listpage      = $i + 1;
      	if ($i == ($liststart/$listlimit)) {
      	  $pagenavigator .= "<span class=\"uip_listpagenavlink\">" . $listpage . "</span> ";	  
      	} else { 
      	  $pagenavigator .= "<span class=\"uip_listpagenavlink\"><a href=\"list_cal.php?";
          $pagenavigator .= "start=" . $listpagestart;
          if ($sort){
            $pagenavigator .= "&amp;sort=" . $sort;
          }                    
          $pagenavigator .= $tag . "\">" . $listpage . "</a></span> ";
      	}
      }
    }
    $pagenavigator .= "</p>\n";
    $string = $pagenavigator;	  
    if ($liststart) {
      $tag .= "&amp;start=" . $liststart;
    }  
    $query = "SELECT ID, title, post_date, start_time, status, 
	       expire_date, weight, topic_id, section_id
	      FROM $tbl_name_cal";
    if ($section_id != "") {
      $query .= " WHERE section_id = '$section_id'";
      if ($srchqry || $draft){
        $query .= " AND ";
      } 
    }
    if ($srchqry){
      if ($section_id == "") {
        $query .= " WHERE ";
      }
      $query .= "(title LIKE '%".$srchqry."%'" .
    	  	" OR summary LIKE '%".$srchqry."%')";
    }                    
    if ($draft){
      if (($section_id == "") && ($srchqry == "")) {
        $query .= " WHERE ";
      }
      $query .= "status = '2'";
    }   
		if ($sort) {
			$sort = split("/",$sort);
			//decide what to inverse
			$sort_r = ($sort[1] == 'desc') ? "asc" : "desc";
		} else { //else default sorting/column
			$sort[0] = 'post_date';
			$sort[1] = 'desc';
			$sort_r = "desc";				
		}    
		$query .= " ORDER BY ".$sort[0]." ".$sort[1];
    if ($liststart) {
      $query .= " LIMIT $liststart, $listlimit";
    } else {
      $query .= " LIMIT $listlimit";
    }
    $result = mysql_query($query); 
    
    // Set up table and legend    
    $string .= "<table bgcolor=\"#cccccc\" border=\"0\"
		cellspacing=\"2\" cellpadding=\"2\"> \n	<tr>"
                . "<td bgcolor=\"#cccccc\"><a title=\"Preview this Section\" href=\"" . $section_dir_cal[$section_id] . "/index.php \" target=\"_blank\">Preview this Section</a></td>"		
                . "<td><font size=-2> - Legend:</font></td>" 
                . "<td " . $col_online 
                . "><font size=-2>Item Online</font></td>"
                . "<td " . $col_offline 
                . "><font size=-2>Item Offline</font></td>"
                . "</tr></table>"
                . "<table bgcolor=\"#cccccc\" border=\"0\" 
		    cellspacing=\"0\" cellpadding=\"0\">
		    <tr><td bgcolor=\"#cccccc\"> \n"
                . "<table bgcolor=\"#cccccc\" border=\"0\" 
		cellspacing=\"2\" cellpadding=\"2\"> \n
		<tr bgcolor=\"#999999\">
		<td color=\"#cccccc\"><a title=\"Add a new event item\" href=\"add_cal.php";
    if ($section_id != "") {
	    $string .= "?section_id=" . $section_id;
    }
    $string .= "\"  class=\"button\"\">Add</a></td>			
		<td><font size=\"-1\"><strong>ID</strong></font></td>
		<td><font size=\"-1\">Title</font></td>
		<td><font size=\"-1\"><a title=\"Sort by Category\" href=\"list_cal.php?" . $tag . "&amp;sort=topic_id/" . $sort_r . "\">Category</font></td>
		<td><font size=\"-1\">Live</font></td>
		<td><font size=\"-1\"><a title=\"Sort by Publishing Status\" href=\"list_cal.php?" . $tag . "&amp;sort=status/" . $sort_r . "\">Post</font></td>
		<td><font size=\"-1\"><a title=\"Sort by Event Date\" href=\"list_cal.php?" . $tag . "&amp;sort=post_date/" . $sort_r . "\">Event Date</font></td>
		<td><font size=\"-1\">Time</font></td>
		<td><font size=\"-1\"><a title=\"Sort by End Date\" href=\"list_cal.php?" . $tag . "&amp;sort=expire_date/" . $sort_r . "\">End Date</font></td>
		<td><font size=\"-1\"><a title=\"Sort by Priority\" href=\"list_cal.php?" . $tag . "&amp;sort=weight/" . $sort_r . "\">Front Page</font></td>
		<td>&nbsp;</th>
		</tr>";
		
    while ($row = mysql_fetch_object($result)) {
    	$title          = stripslashes($row->title);
      $topic_idx      = $row->topic_id;
    	$post_date      = $row->post_date;
    	$start_time     = time_convert($row->start_time, 1);	
    	$id             = $row->ID;
    	$weight         = $row->weight;
    	$expire_date    = $row->expire_date;
    	$status         = $row->status;	
    	$tablerow_prn = "<tr>";

    	$title = "<a title=\"Preview this Item\" href=\"" . $section_dir_cal[$section_id] . "/item.php?id=" . $id . "\" target=\"_blank\">" . $title . "</a>";
    	// Create color-coded table cell for Post Status (status)
    	switch ($status) {
    	 case "1":
    	    $status_prn = $cellcol_on 
    	      . "<font size=\"-2\">Publish</font></td>";
    	    $publish_switch = "on";
    	    break;
    	 case "2":
    	    $status_prn = $cellcol_off 
    	      . "<font size=\"-2\">Draft</font></td>";
    	    $publish_switch = "off";
    	    break;
    	 default: 
    	    $status_prn = $cellcol_err 
    	      . "<font size=\"-2\">Unknown</font></td>";
    	    $publish_switch = "off";
    	}
    		
    	// Create color coded table cell color for Weight (Front Page)
    	switch ($weight) {
    	 case "1":
    	    $weight_prn = "<td bgcolor=\"ooccff\">
    			    <font size=\"-2\">Yes</font></td>";
    	    break;
    	 case "2":
    	    $weight_prn = "<td bgcolor=\"#00ffff\">
    			    <font size=\"-2\">No</font></td>";
    	    break;   
    	 default: 
    	    $weight_prn = "<td><font size=\"-2\">Unknown</font></td>";
    	}
    	
    	// Create color coded table cell for End and Start date
    	if ($expire_date >= substr($now_datetime, 0, 10)) {
    	    $expire_date_prn = $cellcol_on . "<font size=\"-2\">" 
    	      . format_datelong($expire_date) . "</font></td>";
    	// Create color coded table cell for Event start date
        	if ($post_date < substr($now_datetime, 0, 10)) {
        	    $post_date_prn = $cellcol_now . "<font size=\"-2\">" 
        	      . format_datelong($post_date) . "</font></td>";
      	      $start_time_prn = $cellcol_now . "<font size=\"-2\">" 
        	      . $start_time . "</font></td>";
          } else {
        	    $post_date_prn = $cellcol_on . "<font size=\"-2\">" 
        	      . format_datelong($post_date) . "</font></td>";
      	      $start_time_prn = $cellcol_on . "<font size=\"-2\">" 
        	      . $start_time . "</font></td>";
        	}
    	} else {
    	    if ($expire_date == "0000-00-00") {
          		$expire_date_prn = $cellcol_on 
          		  . "<font size=\"-2\">No date</font></td>";
    	// Create color coded table cell for Event start date
            	if ($post_date < substr($now_datetime, 0, 10)) {
            	    $post_date_prn = $cellcol_now . "<font size=\"-2\">" 
            	      . format_datelong($post_date) . "</font></td>";
      	      $start_time_prn = $cellcol_now . "<font size=\"-2\">" 
        	      . $start_time . "</font></td>";
            	      
              } else {
            	    $post_date_prn = $cellcol_on . "<font size=\"-2\">" 
            	      . format_datelong($post_date) . "</font></td>";
      	      $start_time_prn = $cellcol_on . "<font size=\"-2\">" 
        	      . $start_time . "</font></td>";        	      
            	}
    	    } else {
          		$expire_date_prn = $cellcol_off . "<font size=\"-2\">" 
          		  . format_datelong($expire_date) . "</font></td>";
              $post_date_prn = $cellcol_off . "<font size=\"-2\">" 
                . format_datelong($post_date) . "</font></td>";
      	      $start_time_prn = $cellcol_off . "<font size=\"-2\">" 
        	      . $start_time . "</font></td>";        	      
          		$publish_switch = "off";
    	    }
    	}
    	
    	//  Create  color coded table cell for Publish and 
    	// Table Row  Color
    	switch ($publish_switch) {
    	 case "on":
    	    $publish_prn = "<td><font size=\"-2\">Online</font></td>";
    	    $tablerow_prn = "<tr " . $col_online . ">";
    	    break;
    	 default:
    	    $publish_prn = "<td><font size=\"-2\">Offline</font></td>";
    	    $tablerow_prn = "<tr " . $col_offline . ">";
    	    break;
    	}
    	
    	// Print out Table Rows		
    	$string .= $tablerow_prn
        . "<td><a title=\"Edit this item\" href=\"mod_cal.php?id=" 
        . $id . "\" class=\"button\">Edit</a></td>"
        . "<td align=right><font size=-2>" 
        . $id . "</font></td><td>" 
        . $title . "</a></td><td><font size=-2>"
        . $topic[$topic_idx] . "</font></td>"
        . $publish_prn . $status_prn
        . $post_date_prn . $start_time_prn . $expire_date_prn 
        . $weight_prn 
        . "<td><a title=\"Delete this item\" href=\"confirm_cal.php?id=" 
        . $id . "\" class=\"button\">Delete</a></td></tr> \n";
    }
    $page_list_cal = $string . "</table></td></tr></table>\n" . $pagenavigator;
}

/* FUNCTION: get_adminitem_cal
 * Get information for the specified item and set variables
 * Usage: get_adminitem_cal($id)
 * 
 * CAUTION: This function sets global variables that may
 * conflict the ones you are using. This function is written 
 * for the mod.php file. 
 */
 
function get_adminitem_cal($id) {
    global $tbl_name_cal;
    global $now_datetime;
    global $post_date;
    global $start_time;
    global $expire_date;
    global $end_time;
    global $status;
    global $weight;
    global $title;    
    global $summary;
    global $content;
    global $link_title;
    global $link_url;
    global $filepath;
    global $topic_id;
    global $section_id_cal;
    
    if ($id == "") {
	echo display_err("No ID.");
    } else {
	$query = "SELECT * FROM $tbl_name_cal
		   WHERE ID = $id 
		   ";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	if (!$row) {
	    echo display_err("Couldn't find that page.");
	    exit();
	} else {   	    
	    $post_date       = $row->post_date;
	    $start_time      = time_convert($row->start_time, 2);
	    $expire_date     = $row->expire_date;
	    $end_time        = time_convert($row->end_time, 2);
	    $status          = $row->status;
	    $weight          = $row->weight;
	    $title           = $row->title;
	    $summary         = $row->summary;
	    $content         = $row->content;
	    $link_title      = $row->link_title;
	    $link_url        = $row->link_url;
	    $filepath        = $row->filepath;
      $topic_id        = $row->topic_id;
	    $section_id_cal  = $row->section_id;
	}
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
    global $page_summary;
    global $page_content;
    global $page_title;
    global $page_linktitle;
    global $page_linkurl;
    global $page_link;
    if ($id == "") {
	echo display_err("No ID.");
    } else {
	$query = "SELECT * FROM $tbl_name_cal
		   WHERE ID = $id";
	  
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	if (!$row) {
	    echo display_err("Couldn't find that page.");
	    exit();
	} else {   
	    $page_title      = stripslashes($row->title);
	    $page_summary    = stripslashes($row->summary);
	    $page_content    = stripslashes($row->content);
	    $page_linktitle  = stripslashes($row->link_title);
	    $page_linkurl    = stripslashes($row->link_url);
	    $page_postdate   = stripslashes($row->post_date);
	    $page_starttime  = time_convert(stripslashes($row->start_time), 1);
	    if ($page_starttime) { $page_title .= " - " . $page_starttime; }
	    // set date format for item
	    $page_postdate   = format_datelong($page_postdate);
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

/* FUNCTION: delete_item_cal
 * Delete the item
 * Usage: delete_item_cal($id)
 */

function delete_item_cal($id) {
    global $tbl_name_cal;
    $query = "DELETE FROM $tbl_name_cal WHERE ID = $id";    
    $result = mysql_query($query);
    if ($result) {
	    echo("<p><strong>Successful!</strong> 
		   Go back to the <a href=\"list_cal.php\">Manage Events</a> 
		   page.</p>");
    }
}

// COMMON FUNCTIONS

/* FUNCTION: filter_html
 * Delete the item
 * Usage: html_filter($html)
 * 
 * Removes all tags that are considered unsafe 
 * 
 * This function is written by toni@dse.nl (28-Jun-2001) 
 * http://www.php.net/manual/en/function.strip-tags.php
 *
 * After you set $tags below, 
 * modify uipublish_admin/htmltags.php as needed.
 * 
 */

function filter_html($html, $tags = "a.*?|b|br|em|h\d|i|img.*?|p|strong|table.*?|td.*?|th.*?|tr.*?|ul|ol|li") {     
//kill early as a test
    return($html);

    // why should there be a null character 
    $html = preg_replace('/\0/', '', $html); 
    // convert the ampersants to null characters 
    $html = preg_replace('/\&/', '\0', $html); 
    // convert the sharp brackets to there html code 
    $html = preg_replace('/</', '&lt;', $html); 
    $html = preg_replace('/>/', '&gt;', $html); 
    // restore the tags that are concidered safe 
    if ($tags) { 
	$html = preg_replace("/&lt;($tags.*?)&gt;/i", '<\1>', $html); 
	$html = preg_replace("/&lt;\\/($tags)&gt;/i", '</\1>', $html); 
    } 
    // restore the ampersants 
    $html = preg_replace('/\0/', '&', $html); 
   
    return($html); 
}

/* FUNCTION: navbar
 * Print out the Section Navigation bar
 * Usage: navbar()
 */
 
function navbar() {
global $section, $section_cal, $kfm;

    echo ("<div class=\"navbar\">\n");
    echo ("<a href=\"index.php\" class=\"navbarlink\">Control Panel</a> |\n");
    $section_count = count($section);
    for ($idx = 0; $idx < $section_count; ++$idx) {
        echo "<a href=\"list.php?section_id=" . $idx 
  	. "\" class=\"navbarlink\">$section[$idx]</a>\n";
    }
    echo ("| ");
    $section_count_cal = count($section_cal);
    for ($idx = 0; $idx < $section_count_cal; ++$idx) {
        echo "<a href=\"list_cal.php?section_id=" . $idx 
  	. "\" class=\"navbarlink\">$section_cal[$idx]</a>\n";
    }
    echo ("| ");
    if ($kfm) {
      echo ("<a href=\"$kfm\" class=\"navbarlink\" target=\"_blank\">FileManager</a> |\n");
    } else {
      echo ("<a href=\"filemanager.php\" class=\"navbarlink\">FileManager</a> |\n");
    }  
    echo ("<a href=\"help/index.html\" class=\"navbarlink\" target=\"uipublishhelp\">Help</a>\n</div>\n");
}

?>
