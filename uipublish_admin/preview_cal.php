<?
// $Id: preview_cal.php,v 1.5 2003/03/31 07:42:04 chavan Exp $


/* Description:   Takes in values supplied by add_cal.php or mod_cal.php
 *                Checks if all required fields have been supplied. 
 *                If there are any missing values it does not display
 *                an "apply" button and asks the user to go back and
 *                enter in missing values. 
 *                If all required fields are supplied with values then
 *                displays an "add/apply" button. 
 *                Passes the data to apply_cal.php
 */
?>

<? $wysiwyg = ""; ?>
<? include ("inc/top.php") ?>

<h1>Preview Event</h1>
<p>

<? 
  /* clean up the content for display */
  
$id                =  htmlentities(stripslashes(trim($id)));  
$title_prn         =  htmlentities(stripslashes(trim($title)));
$summary_prn       =  htmlentities(stripslashes(trim($summary)));
$content_prn       =  nl2br(filter_html(stripslashes(trim($content))));
$post_year_prn     =  htmlentities(stripslashes(trim($post_year)));
$post_month_prn    =  htmlentities(stripslashes(trim($post_month)));
$post_day_prn      =  htmlentities(stripslashes(trim($post_day))); 
//$start_time_prn    =  htmlentities(stripslashes(trim($start_time))); 
$expire_year_prn   =  htmlentities(stripslashes(trim($expire_year)));
$expire_month_prn  =  htmlentities(stripslashes(trim($expire_month)));
$expire_day_prn    =  htmlentities(stripslashes(trim($expire_day))); 
//$end_time_prn      =  htmlentities(stripslashes(trim($end_time))); 
$status_prn        =  htmlentities(stripslashes(trim($status)));
$weight_prn        =  htmlentities(stripslashes(trim($weight)));
$link_title_prn    =  htmlentities(stripslashes(trim($link_title)));
$link_url_prn      =  htmlentities(stripslashes(trim($link_url)));
$filepath_prn      =  htmlentities(stripslashes(trim($filepath)));
$topic_id          =  htmlentities(stripslashes(trim($topic_id)));
$section_id        =  htmlentities(stripslashes(trim($section_id_cal)));
$copy              =  htmlentities(stripslashes(trim($copy)));
if ($copy == "ON") {
    $id = "";
    echo "<b>Copy being created! </b><BR>";
}

/* Assemble dates */
// Check if dates is valid 
$post_date_prn = format_form2date("$post_year_prn", 
				  "$post_month_prn", 
				  "$post_day_prn");
$expire_date_prn = format_form2date("$expire_year_prn", 
				    "$expire_month_prn", 
				    "$expire_day_prn");
$start_time_prn = time_convert($start_time, 1);
$end_time_prn = time_convert($end_time, 1);

/* Print out submitted content and check if all required fields
 * have been entered
 */

// Set Error message for Required fields
$msg_required = "<font size=\"-2\" color=\"#ff0000\">* Required field. 
		  Please go back and enter a value for this field.</font>";

// Set Warning message for blank field
$msg_blank = "<font size=\"-2\" color=\"#666666\">No value.</font>";

// Set variable for checking required fields:
$check_required = "y";
?>
<form action="apply_cal.php" method="post">
<? 
// Print table with values
echo "<table border=\"0\">";

// Title - Required
echo "<tr><td valign=\"top\"><label>Title:</label></td>";
switch ($title_prn) {
 case "":
    echo "<td>" . $msg_required . "</td>";
    $check_required = "n";
    break;
 default :
    echo "<td><h3>" . $title_prn . "</h3></td>";
    break;
}
echo "</tr>";

// Post Date - Required 
echo "<tr><td><label>Event Date:</label></td>";
switch ($post_date_prn) {
 case "":
    echo "<td>" . $msg_required 
      . " <font size=-2 color=#666666>(Or invalid date)</font> </td>";
    $check_required = "n";
    break;
 default :
    echo "<td>" . format_datelong($post_date_prn) . " ";
    if ($start_time_prn) {echo "@ " . $start_time_prn;}    
    echo  "</td>";
    break;
}
echo "</tr>";

// Expire Date
echo "<tr><td><label>End Date:</label></td>";
switch ($expire_date_prn) {
 case "":
    echo "<td>" . $msg_blank 
      . " <font size=-2 color=#666666>(Or invalid date)</font></td>";
    break;
 default :
    echo "<td>" . format_datelong($expire_date_prn) . " ";
    if ($end_time_prn) {echo "@ " . $end_time_prn;}
    echo "</td>";
    break;
}
echo "</tr>";

// Approval (Status)- Required
echo "<tr><td><label>Status:</label></td>";
switch ($status_prn) {
 case "":
    echo "<td>" . $msg_required . "</td>";
    $check_required = "n";
    break;
 case "1":
    echo "<td>Publish</td>";
    break;
 default :
    echo "<td>Draft</td>";
    break;
}
echo "</tr>";

// Visibility (Weight) - Required
echo "<tr><td><label>Front Page:</label></td>";
switch ($weight_prn) {
 case "":
    echo "<td>" . $msg_required . "</td>";
    $check_required = "n";
    break;
 case "1":
    echo "<td>Yes</td>";
    break;
  case "3":
    echo "<td>Low</td>";
    break;
 default :
    echo "<td>No</td>";
    break;
}
echo "</tr>";

// Summary
echo "<tr width=\"100%\"><td valign=\"top\"><label>Summary:</label></td>";
echo "<td width=\"100%\"><table border=\"1\" style=\"border-collapse: collapse\" width=\"100%\"><tr>";
switch ($summary_prn) {
 case "":
    echo "<td>" . $msg_blank . "</td>";
    break;
 default :
    echo "<td>" . $summary_prn . "</td>";
    break;
}
echo "</tr></table></tr>";

// Content
echo "<tr width=\"100%\"><td valign=\"top\"><label>Content:</label></td>";
echo "<td width=\"100%\"><table border=\"1\" width=\"100%\"><tr>";
switch ($content_prn) {
 case "":
    echo "<td valign=\"top\">" . $msg_blank . "</td>";
    break;
 default :
    echo "<td>" . $content_prn . "</td>";
    break;
}
echo "</tr></table></tr>";

// Link_URL
echo "<tr><td><label>Link URL:</label></td>";
switch ($link_url_prn) {
 case "":
    echo "<td>" . $msg_blank . "</td>";
    break;
 default :
    echo "<td><a href=\"" 
      . $link_url_prn . "\">" . $link_url_prn . "</a></td>";
    break;
}
echo "</tr>";

// Filepath
echo "<tr><td><label>Enclosure:</label></td>";
if ($filepath_prn) {
    $filepath    = $base_path . $filepath_prn;
    if (file_exists($filepath)) {
		    if (!$file=fopen($filepath, "r")) {
		        $filepath_prn = "*";
		    }
    } else {
		    $filepath_prn = "* " . $filepath_prn;    
    }
}
switch ($filepath_prn[0]) {
 case "":
    echo "<td>" . $msg_blank . "</td>";
    break;
 case "*":
    echo "<td><font size=\"-2\" color=\"#ff0000\">File NOT Found!</font> - ". $filepath_prn . "</td>";
    break;    
 default :
     echo "<td><a href=\"" 
      . $filepath_prn . "\">" . $filepath_prn . "</a></td>";
    break;
}

// Section
echo "<tr><td><label>Section:</label></td>";
switch ($section_id) {
 case "":
    echo "<td>" . $msg_required . "</td>";
    break;
 default :
    echo "<td>" . $section_cal[$section_id] . "</td>";
    break;
}

// Topic
echo "<tr><td><label>Topic:</label></td>";
switch ($topic_id) {
 case "":
    echo "<td>" . $msg_blank . "</td>";
    break;
 default :
    echo "<td>" . $topic[$topic_id] . "</td>";
    break;
}

echo "</tr>";
echo "</table>";

// If all required fields are entered show "submit" button 
if ($check_required == "n") {
    echo "<p><font color=\"#ff0000\">Some required information 
	    has not been entered."
          . "Please go back and enter the missing information</font></p>";
} else {
?>

<input type="hidden" name="id" value="<? echo (htmlentities($id)); ?>">
<input type="hidden" name="title" value="<? echo (htmlentities($title)); ?>">
<input type="hidden" name="summary" value="<? echo (htmlentities($summary)); ?>">
<input type="hidden" name="content" value="<? echo (urlencode($content)); ?>">
<input type="hidden" name="post_year" value="<? echo ($post_year); ?>">
<input type="hidden" name="post_month" value="<? echo ($post_month); ?>">
<input type="hidden" name="post_day" value="<? echo ($post_day); ?>">
<input type="hidden" name="start_time" value="<? echo (htmlentities($start_time)); ?>">
<input type="hidden" name="expire_year" value="<? echo ($expire_year); ?>">
<input type="hidden" name="expire_month" value="<? echo ($expire_month); ?>">
<input type="hidden" name="expire_day" value="<? echo ($expire_day); ?>">
<input type="hidden" name="end_time" value="<? echo (htmlentities($end_time)); ?>">
<input type="hidden" name="status" value="<? echo ($status); ?>">
<input type="hidden" name="weight" value="<? echo ($weight); ?>">
<input type="hidden" name="link_title" value="<? echo (htmlentities($link_title)); ?>">
<input type="hidden" name="link_url" value="<? echo (htmlentities($link_url)); ?>">
<input type="hidden" name="filepath" value="<? echo (htmlentities($filepath)); ?>">
<input type="hidden" name="topic_id" value="<? echo ($topic_id); ?>">
<input type="hidden" name="section_id" value="<? echo ($section_id); ?>">
<br>

<?
if ($server_script) {
  echo "<input type=\"checkbox\" name=\"postcal\" value=\"ON\"> Also post this event to the calendar named <b>$calendar</b>";
}
?>
<center>
<input type="submit" value="Submit">
</center>
<br>
<hr>
</form>
<form action="apply.php" method="post">
<input type="hidden" name="id" value="">
<input type="hidden" name="title" value="<? echo (htmlentities($title)); ?>">
<input type="hidden" name="summary" value="<? echo (htmlentities($summary)); ?>">
<input type="hidden" name="content" value="<? echo (urlencode($content)); ?>">
<input type="hidden" name="post_year" value="<? echo ($expire_year); ?>">
<input type="hidden" name="post_month" value="<? echo ($expire_month); ?>">
<input type="hidden" name="post_day" value="<? echo ($expire_day); ?>">
<input type="hidden" name="expire_year" value="">
<input type="hidden" name="expire_month" value="">
<input type="hidden" name="expire_day" value="">
<input type="hidden" name="status" value="<? echo ($status); ?>">
<input type="hidden" name="weight" value="<? echo ($weight); ?>">
<input type="hidden" name="link_title" value="<? echo (htmlentities($link_title)); ?>">
<input type="hidden" name="link_url" value="<? echo (htmlentities($link_url)); ?>">
<input type="hidden" name="filepath" value="<? echo (htmlentities($filepath_prn)); ?>">
<input type="hidden" name="topic_id" value="<? echo ($topic_id); ?>">
<input type="submit" value="Post Item as an Article">  in Section: 
<select name="section_id">
<? 
 $section_count = count($section);
 for ($idx = 0; $idx < $section_count; ++$idx) {
     if ($idx == $section_id) {
	 echo ("<option selected value=\"$idx\">$section[$idx]</option>\n");
     } else {
	 echo ("<option value=\"$idx\">$section[$idx]</option>\n");
     }
 }
?> 
</select>

<? } ?>

</form>

<? $datepop = ""; $timepop = ""; ?>
<? include ("inc/bot.php") ?>

