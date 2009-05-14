<?
// $Id: top.php,v 1.6 2003/04/15 19:28:03 chavan Exp $
// $Name: Rel-0_7_1 $

/* Description:   Include file for header (Admin Version) */

/* Required functions */
require ("inc/config.php");
require ("inc/globals.php");
require ("inc/common.php");
require ("inc/connect_db.php");
require ("inc/display_err.php");
require ("inc/format_date.php");

/* Connect to the database */
connect_db();
?>

<html>
<head>
<title><? echo $base_pagetitle; ?>: <? echo $base_modulename; ?></title>
<link rel="stylesheet" href="inc/style.css">	    
<?php
global $kfm;
if ($kfm) { 
?>
<script type="text/javascript">
	function init(){
		var els=document.getElementsByTagName('*');
		var reg=/(^| )kfm($| )/;
		for(i in els){
			var el=els[i];
			if(reg.test(el.className))el.onclick=function(){
				window.SetUrl=(function(id){
					return function(value){
						value=value.replace(/[a-z]*:\/\/[^\/]*/,'');
						document.getElementById(id).value=value;
					}
				})(this.id);
				var kfm_url = "<?php echo $kfm ?>";
				window.open(kfm_url,'kfm','modal,width=800,height=600');
			}
		}
	}
</script>
<?php 
}
global $fckeditor, $wysiwyg;
if ($fckeditor && $wysiwyg) { 
?>
<script type="text/javascript" src="<?php echo $fckeditor ?>fckeditor.js"></script>
    <script type="text/javascript">
      window.onload = function()
      {
        var oFCKeditor = new FCKeditor( 'content' ) ;
        oFCKeditor.BasePath = "<?php echo $fckeditor ?>" ;
        oFCKeditor.ReplaceTextarea() ;
        oFCKeditor.Height = 400 ; // 400 pixels
        init();
      }
</script>
<?php 
}
?> 
</head>
<body>

<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
  <tr>
    <td width="60" valign="bottom">  
    <a href="index.php"><img border="0" alt = "UIPublish" src="inc/uipublish.gif"></a>
    </td>  
    <td valign="bottom" align="left">
    <strong>UIPublish</strong><br>    
    </td>
    <td valign="bottom" align="right">
    <a href="<? echo $base_url; ?>"><? echo $base_websitename; ?>    
    </td>       
  </tr>
</table>  

<?php navbar() ?>

<script type="text/javascript">

// Strip HTML Tags (form) script- By JavaScriptKit.com (http://www.javascriptkit.com)
// For this and over 400+ free scripts, visit JavaScript Kit- http://www.javascriptkit.com/
// This notice must stay intact for use

function stripIt(strText, size){
  var strOutput = strText
  var re= /<\S[^><]*>/g

  strOutput=strOutput.replace(re, "")
  return strOutput.slice(0, size)
}

</script>
