<?
// $Id: index.php,v 1.6 2003/05/21 22:52:10 chavan Exp $

?>

<? $wysiwyg = ""; ?>
<? include ("inc/top.php") ?>
<? include("inc/version.php"); ?>

<h2>UIPublish Control Panel</h2>

<div style="margin-left: 5%; margin-right: 10%;">
<p>
This control panel enables you to manage
UIPublish content on this website.
</p>

<table width="100%">
<tr valign="top">
<td>
<h3>Article Sections</h3>
<ul>	
<?
  $section_count = count($section);
  for ($idx = 0; $idx < $section_count; ++$idx) {
    get_listcount($idx);
  }
?>
</ul>
</td>
<td>
<h3>Most Recent Article Entries</h3>      
<ul>     
<?
  get_recent();
  echo "<li><a href=\"add.php\"><b><i>Add a New Article Item</i></b></a></li>\n";  
?>
</ul>
</td>
</tr>
<tr valign="top">
<td>
<h3>Event Sections</h3>
<ul>	
<?
  $section_count_cal = count($section_cal);
  for ($idx = 0; $idx < $section_count_cal; ++$idx) {
    get_listcount_cal($idx);
  }
?>
</ul>	
</td>
<td>
<h3>Most Recent Event Entries</h3>
<ul>
<?
  get_recent_cal();
  echo "<li><a href=\"add_cal.php\"><b><i>Add a New Calendar Event</i></b></a></li>\n";   
?>
</ul>
</td>
</tr>
</table>

<p style="font-size: 80%; color: #666666">UIPublish: <?php echo $versioninfo;?><br>
<a href="http://uipublish.sourceforge.net">uipublish.sourceforge.net</a>
</p>

</div>
<?
function get_listcount($section_id = "") {
    global $tbl_name;
    global $section;
    global $section_dir;
    
    echo "<li><strong><a title=\"Preview this Section\" href=\"" . $section_dir[$section_id] . "/index.php \" target=\"_blank\">$section[$section_id]</a></strong>";    
    $query_listcount = "SELECT ID FROM $tbl_name 
                        WHERE section_id = '$section_id'
                        ORDER BY post_date DESC";
    $query_listcount_result = mysql_query($query_listcount);
    $listcount              = mysql_num_rows($query_listcount_result);
    echo " - <a title=\"Manage this Section\" href=\"list.php?section_id=" . $section_id 
	     . "\">" . $listcount . " Items Posted</a>";
    
    $query_listcount = "SELECT ID FROM $tbl_name 
                        WHERE section_id = '$section_id'
                        AND status = 2
                        ORDER BY post_date DESC";
    $query_listcount_result = mysql_query($query_listcount);
    $listcount              = mysql_num_rows($query_listcount_result);
    if ($listcount) {
      echo " - <a title=\"Manage these Drafts\" href=\"list.php?section_id=" . $section_id 
  	    . "&draft=1\">" . $listcount . " Drafts</a></li>\n";    
	  } else {
      echo " - $listcount Drafts</li>\n";    
    }
}

function get_listcount_cal($section_id = "") {
    global $tbl_name_cal;
    global $section_cal;
    global $section_dir_cal;
    
    echo "<li><strong><a title=\"Preview this Section\" href=\"" . $section_dir_cal[$section_id] . "/index.php \" target=\"_blank\">$section_cal[$section_id]</a></strong>";
    $query_listcount = "SELECT ID FROM $tbl_name_cal 
                        WHERE section_id = '$section_id'
                        ORDER BY post_date DESC";
    $query_listcount_result = mysql_query($query_listcount);
    $listcount              = mysql_num_rows($query_listcount_result);
    echo " - <a title=\"Manage this Section\" href=\"list_cal.php?section_id=" . $section_id 
	    . "\">" . $listcount . " Events Posted</a>";
    
    $query_listcount = "SELECT ID FROM $tbl_name_cal 
                        WHERE section_id = '$section_id'
                        AND status = 2                        
                        ORDER BY post_date DESC";
    $query_listcount_result = mysql_query($query_listcount);
    $listcount              = mysql_num_rows($query_listcount_result);
    if ($listcount) {
      echo " - <a title=\"Manage these Drafts\" href=\"list_cal.php?section_id=" . $section_id 
  	    . "&draft=1\">" . $listcount . " Drafts</a></li>\n";   
	  } else {
      echo " - $listcount Drafts</li>\n";    
    }
}

function get_recent($limit = 5) {
    global $tbl_name;

    $query = "SELECT ID, title, modify_date FROM $tbl_name 
	       ORDER BY modify_date DESC LIMIT $limit";
    
    $result = mysql_query($query); 
    while ($row = mysql_fetch_object($result)) {
    	$title          = stripslashes($row->title);
    	$page_moddate  = $row->modify_date;
    	$id             = $row->ID;
    	// Set date format for list
    	$page_moddate  = format_datelong($page_moddate);
    	$string .= "<li>";
//      $string .= $page_moddate . " - ";
    	$string .= "<a href=\"";
	    $string .= "mod.php?id=" . $id;
      $string .= "\"";
    	$string .= ">" . $title . "</a></li> \n";
    }
    $recent_list = $string . "";
    if ($recent_list == "") {
        $recent_list =  "<b>NONE AVAILABLE!</b>";
    }
    echo $recent_list;
}

function get_recent_cal($limit = 5) {
    global $tbl_name_cal;

    $query = "SELECT ID, title, modify_date FROM $tbl_name_cal 
	       ORDER BY modify_date DESC LIMIT $limit";
    
    $result = mysql_query($query); 
    while ($row = mysql_fetch_object($result)) {
    	$title          = stripslashes($row->title);
    	$page_moddate  = $row->modify_date;
    	$id             = $row->ID;
    	// Set date format for list
    	$page_moddate  = format_datelong($page_moddate);
    	$string .= "<li>";
//      $string .= $page_moddate . " - ";
    	$string .= "<a href=\"";
	    $string .= "mod_cal.php?id=" . $id;
      $string .= "\"";
    	$string .= ">" . $title . "</a></li> \n";
    }
    $recent_list = $string . "";
    if ($recent_list == "") {
        $recent_list =  "<b>NONE AVAILABLE!</b>";
    }
    echo $recent_list;
}
?>

<? $datepop = ""; $timepop = ""; ?>
<? include ("inc/bot.php"); ?>
