<?
// $Id: config.php,v 1.7 2003/04/15 19:32:00 chavan Exp $

/* Filesystem relative path name to the main uipublish include directory */
require ("../../inc/config.php");

/* Page Title Prefix for the website e.g. "UI" */
$base_pagetitle = "Admin-UIPublish";

/* optional(??)) aid - used for pop-up calendar helper */
/* PopCalendarXP Location  e.g. "/apps/PopCalendarXP/" or "" if not used*/
$popcalendarxp = "/apps/PopCalendarXP/";

/* optional aid - used for WYSIWYG editing */
/* FCKeditor Location  e.g. "/apps/fckeditor/" or "" if not used*/
$fckeditor = "/apps/fckeditor/";

/* optional aid - used for server file management */
/* Kae's File Manager Location  e.g. "/apps/fckeditor/editor/plugins/kfm/" or "" if not used*/
$kfm = "/apps/fckeditor/editor/plugins/kfm/";

/* optional aid - used to tie events to webcalendar program */
/* the following is Webcal calendar related */
/* URL Link to Webcal server script */
$server_script = "http://www.website.com/cgi-bin/wcal/webcal_cmd_server.pl";

/* the following is Webcalendar calendar related */
/* URL Link to Webcalendar publish script */
//$webcalendar = true;
//$server_script = "http://www.website.com/webcalendar/icalclient.php";

/* Calendar name, password, & time zone */
$calendar = "main";
//$calendar = "admin";
$calendar_password = "password";
$tz = 0;

?>
