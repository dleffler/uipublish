<?
// $Id: add.php,v 1.6 2003/05/21 22:41:37 chavan Exp $ 


/* Description:   Displays a form to add an article item.
 *                Passes the data to uipublish_admin/preview.php
 */
?>

<? $wysiwyg = "true"; include ("inc/top.php") ?>

<h2>Add New Item
<?
if ($section_id != "") {
  echo "to " . $section[$section_id];
}
?>
</h2>
<form name="add_form" action="preview.php" method="post">

<table border="0">
 <tr valign="top">
  <td><label for="title">Title:</label><font color="red">*</font></td>
  <td colspan="3"><input type="text" name="title" id="title" size="80" maxlength="200"></td>
 </tr>

 <tr valign="top">
  <td><label for="post_month">Post Date:</label><font color="red">*</font></td>
  <td><pre><? echo format_date2form($now_datetime, "post"); ?></pre></td>
  <td><label for="expire_month">Expire Date:</label></td>
  <td><pre><? echo format_date2form("", "expire"); ?></pre></td>
 </tr>

 <tr valign="top">
  <td><label for="summary">Summary:</label><br><font size=-2 color=#666666>[Teaser on Front Page.]</font></td>
  <td colspan="3"><textarea name="summary" id="summary" cols="100" rows="3" maxlength="255" wrap="soft"></textarea></td>
 </tr>
 
 <tr valign="top">
  <td>&nbsp;</td>
  <td><Input Type = Button Name = b1 value = "   Trim    " onClick = "document.add_form.summary.value = stripIt(document.add_form.summary.value,250)"></td>
  <td><Input Type = Button Name = b2 value = "   /\    " onClick = "document.add_form.summary.value = stripIt(document.add_form.content.value, 250)"></td>
 </tr>

 <tr valign="top">
  <td><label for="content">Content:</label></td>
  <td colspan="3"><textarea name="content" id="content" cols="100" rows="12" maxlength="65000" wrap="soft"></textarea></td> 
 </tr>
 
 <tr valign="top">
  <td><label for="link_url">Link URL:</label><br><font size=-2 color=#666666>[Send user to a URL]</font></td>
  <td colspan="3"><input type="text" name="link_url" id="link_url" size="80" maxlength="200"></td>
 </tr>

 <tr valign="top">
  <td><label for="file">Enclosure/<br>PodCast file:</label></td>
  <td colspan="3"><input class="kfm" id="file" type="text" name="filepath" size="80" maxlength="200"></td>
 </tr>
 
 <tr valign="top">
  <td><label for="status">Status:</label></td>
  <td><label for="status">Draft:</label>&nbsp;<input type="radio" value="2" checked name="status" id="status">&nbsp;&nbsp;<label for="status2">Publish:</label>&nbsp;<input type="radio" name="status" id="status2" value="1"></td>
  <td><label for="topic_id">Category:</label></td>
  <td><select name="topic_id" id="topic_id">
<? 
 $topic_count = count($topic);
 echo ("<option selected value=\"\">None</option>\n");
 for ($idx = 0; $idx < $topic_count; ++$idx) {
   echo ("<option value=\"$idx\">$topic[$idx]</option>\n");
 }
		       
?> 
  </select></td>
 </tr>

 <tr valign="top">
  <td><label for="weight">Front Page:</label></td>
  <td><label for="weight">Yes:</label>&nbsp;<input type="radio" value="1" checked name="weight" id="weight">&nbsp;&nbsp;<label for="weight2">No:</label>&nbsp;<input type="radio" name="weight" id="weight2" value="2"></td>
  <td><label for="section_id">Section:</label></td>
  <td><select name="section_id" id="section_id">
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
  </select></td>
 </tr>
 
 <tr valign="top">
  <td colspan="4"><center><input type="submit" value="Preview"></center></td>
 </tr>
</table>
</form>
 
<? $datepop = "true"; $timepop = ""; include ("inc/bot.php") ?>
