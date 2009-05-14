<?
// $Id: list_cal.php,v 1.6 2003/04/15 19:48:54 chavan Exp $


/* Description:   Extracts a listing of existing items in 
 *                the database and lists them. Provides
 *                button with links to add_cal.php, mod_cal.php 
 *                and del_cal.php.
 */

// Check 
if (is_numeric($start)) {
  $liststart = $start;
}

if (!isset($search)) {
  $searchquery = "";
} elseif (!$searchquery) {
  $searchquery = $search;
}
?>

<? $wysiwyg = ""; ?>
<? include ("inc/top.php") ?>
<? get_adminlist_cal($section_id, $liststart, $listlimit, $searchquery, $draft, $sort); ?>

<table border="0" width="100%">
 <tr valign="bottom">
  <td><h2>Manage 
<? 
  if ($draft) {
      echo " <i>(DRAFTS)</i> ";
  }
  if ($section_id == "") {
      echo " All Event Sections";
  } else {
      echo " $section_cal[$section_id]";
  }
?>
</h2></td><td align="center">
<? 
  if (isset($search)) {
      echo "(<i>Items Filtered for: \"" . $searchquery . "\"</i>) - ";
      echo "<a href=\"list_cal.php";
      if ($section_id != "") {
          echo "?section_id=" . $section_id;
      }      
      echo "\">Remove Filter</a>";
  } else {
      echo "&nbsp;";
  }
?>
</td><td align="right">
<form action="list_cal.php?search=1
<?
if ($section_id != "") {
  echo "&amp;section_id=$section_id";
}
?>
" method="post">
	<input type="text" name="searchquery" size="28" value="<?php echo $searchquery ?>" />
	<input type="submit" value="Search!" />
</form>
</td>
</tr>
</table>

<? echo $page_list_cal; ?>

<p>
In order for an item to be available on the website (online), 
all of the following two properties must be green:</p>
<ol>
<li>Post: Must be set to "Publish"</li>
<li>End Date: The ending date of the event must be today or in the future.</li>
</ol>
	
[* Note: If your website is configured to display "Past Events" then 
	events in the past will be available online if their status is not Draft.]

<? $datepop = ""; $timepop = ""; ?>
<? include ("inc/bot.php"); ?>
