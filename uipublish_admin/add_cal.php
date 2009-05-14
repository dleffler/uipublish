<?
// $Id: add_cal.php,v 1.8 2003/05/21 22:42:40 chavan Exp $ 


/* Description:   Displays a form to add a calendar item.
 *                Passes the data to uipublish_admin/preview_cal.php
 */
?>

<? $wysiwyg = "true"; ?>
<? include ("inc/top.php") ?>

<h2>Add New Calendar Item
<?
if ($section_id != "") {
  echo "to " . $section_cal[$section_id];
}
?>
</h2>
<form name="add_calform" action="preview_cal.php" method="post">

<table border="0">
 <tr valign="top">
  <td><label for="title">Title:</label><font color="#ff0000">*</font></td>
  <td colspan="3"><input type="text" name="title" id="title" size="80" maxlength="200"></td>
 </tr>

 <tr valign="top">
  <td><label for="post_month">Event Date:<font color="#ff0000">*</font></td>
  <td><pre><? echo format_date2form($now_datetime, "post"); ?></pre></td> 
  <td><label for="expire_month">End Date:</label></td>
  <td><pre><? echo format_date2form("", "expire"); ?></pre></td>
 </tr>
 
 <tr valign="top">  
  <td><label for="start_time">Start Time:</label></td>
  <td><input type="text" name="start_time" id="start_time" size="8">
<? if ($popcalendarxp) {  ?>
  <a href="javascript:void(0)" onclick="if(self.gfPop1)gfPop1.fPopCalendar(document.add_calform.start_time);return false;" ><img name="popcal" align="absmiddle" src="<? echo $popcalendarxp; ?>fs-pat.gif" width="22" height="17" border="0" alt=""></a>
<? } ?>
  </td>  
  <td><label for="end_time">End Time:</label></td>
  <td><input type="text" name="end_time" id="end_time" size="8">
<? if ($popcalendarxp) {  ?>  
  <a href="javascript:void(0)" onclick="if(self.gfPop1)gfPop1.fPopCalendar(document.add_calform.end_time);return false;" ><img name="popcal" align="absmiddle" src="<? echo $popcalendarxp; ?>fs-pat.gif" width="22" height="17" border="0" alt=""></a>
<? } ?>
  </td>
 </tr>
 
 <tr valign="top">
  <td><label for="summary">Summary:</label><br><font size=-2 color=#666666>[Teaser on Front Page.]</font></td>
  <td colspan="3"><textarea name="summary" cols="100" rows="3" maxlength="255" wrap="soft"></textarea></td>
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
  <td><label for="section_id_cal">Section:</label></td>
  <td><select name="section_id_cal" id="section_id_cal">
<? 
 $section_count = count($section_cal);
 for ($idx = 0; $idx < $section_count; ++$idx) {
     if ($idx == $section_id) {
	 echo ("<option selected value=\"$idx\">$section_cal[$idx]</option>\n");
     } else {
	 echo ("<option value=\"$idx\">$section_cal[$idx]</option>\n");
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

<? $datepop = "true"; $timepop = "true"; ?>
<? include ("inc/bot.php") ?>
