<?
// $Id: list.php,v 1.7 2003/04/15 19:48:37 chavan Exp $


/* Description:   Extracts a listing of existing items in 
 *                the database and lists them. Provides
 *                button with links to add.php, mod.php 
 *                and del.php.
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
<? get_adminlist($section_id, $liststart, $listlimit, $searchquery, $draft, $sort); ?>

<table border="0" width="100%">
 <tr valign="bottom">
  <td><h2>Manage 
<? 
  if ($draft) {
      echo " <i>(DRAFTS)</i> ";
  }
  if ($section_id == "") {
      echo " All Article Sections";
  } else {
      echo " $section[$section_id]";
  }
?>
</h2></td><td align="center">
<? 
  if (isset($search)) {
      echo "(<i>Items Filtered for: \"" . $searchquery . "\"</i>) - ";
      echo "<a href=\"list.php";
      if ($section_id != "") {
          echo "?section_id=" . $section_id;
      }       
      echo "\">Remove Filter</a>";
  } else {
      echo "&nbsp;";
  }
?>
</td><td align="right">
<form action="list.php?search=1
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
<? echo $page_list; ?>

<p>
In order for an item to be available on the website (online), 
all of the following three properties must be green:</p>
<ol>
<li>Post: Must be set to "Publish"</li>
<li>Post Date: The earliest date you want the item 
to first be available on the website, must be today or in the past.</li>
<li>Expire Date: The last date you want the item 
to still be available on the website, must be today or in the future.</li>
</ol>

<? $datepop = ""; $timepop = ""; ?>
<? include ("inc/bot.php"); ?>
