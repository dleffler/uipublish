<?
// $Id: del_cal.php,v 1.3 2002/03/12 02:58:08 chavan Exp $ 


/* Description:   Deletes record corresponding to the ID supplied
 *                by confirm_cal.php
 */
?>

<? $wysiwyg = ""; ?>
<? include ("inc/top.php") ?>

<? delete_item_cal($id); ?>

<? $datepop = ""; $timepop = ""; ?>
<? include ("inc/bot.php"); ?>

