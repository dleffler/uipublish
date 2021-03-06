<?
// $Id: confirm.php,v 1.4 2003/03/31 07:26:31 chavan Exp $


/* Description:   Takes in a ID supplied by list.php
 *                and ask the user for a confirmation.
 *                If confirmed, pass the ID to del.php
 */
?>

<? $wysiwyg = ""; ?>
<? include ("inc/top.php") ?>
<? get_item($id) ?>

<h1>Confirm</h2>

<p>You are about to delete Item #<? echo $id; ?>.
Once deleted you cannot restore this item.</p>

<p>Are you sure you want to permanently delete this item?</p>

<p><a href="index.php" class="button">No, do not delete</a></p>
<p><br></p>

<p>
<?  echo "<a href=\"del.php?id=" 
  . $id 
  . "\" class=\"button\">Delete</a></p>"; ?>
  
<table border="0" bgcolor="#cccccc" cellpadding="10">
 <tr>
  <td>
  <h3><? echo $page_title; ?></h3>
  <p><strong><? echo $page_summary; ?></strong></p>
  <p><? echo $page_postdate; ?></p>
  <p><? echo $page_content; ?></p>
  <p><? echo $page_link; ?></p>
  </td>
 </tr>
</table>

<? $datepop = ""; $timepop = ""; ?>
<? include ("inc/bot.php"); ?>
