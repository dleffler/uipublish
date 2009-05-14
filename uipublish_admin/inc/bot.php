<?
// $Id: bot.php,v 1.6 2003/05/21 22:52:33 chavan Exp $

/* Description:   Include footer 
 */
?>

<?php navbar() ?>
<?php
global $popcalendarxp, $datepop, $timepop;
if ($popcalendarxp) { 
  if ($datepop) {
?>
<!--  PopCalendar(tag name and id must match) Tags should not be enclosed in tags other than the html body tag. -->
<iframe width=132 height=142 name="gToday:normal:agenda.js:gfPop:plugins.js" id="gToday:normal:agenda.js:gfPop:plugins.js" src="<? echo $popcalendarxp; ?>ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>
<?php 
  }
  if ($timepop) {
?> 
<iframe width=132 height=142 name="gToday:datetime:agenda.js:gfPop1:plugins_time.js" id="gToday:datetime:agenda.js:gfPop1:plugins_time.js"  src="<? echo $popcalendarxp; ?>ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>
<?php 
  }
}
?> 
</body>
</html>
