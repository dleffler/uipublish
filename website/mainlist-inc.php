<?
// $Id: mainlist-inc.php,v 1.7 2003/05/21 23:29:06 chavan Exp $


// This file is called by list.php
require ("inc/config.php");
require ("inc/globals.php");
require ("inc/common.php");
require ("inc/connect_db.php");
require ("inc/display_err.php");
require ("inc/format_date.php");

connect_db();

// CONFIGURE SECTIONS 

/* Configure Article Sections
 * 
 * This configuration sets the display of lists on the 
 * main page. You should have already set the section
 * configuration in the '~/web/inc/config.php' file.
 * 
 * Example:
 * 
 *   Let's say you want to display two sections: News and 
 *   Reports. The two directories are named 'news' and 
 *   'reports'. On this page the configuration section 
 *   should look like this:
 * 
 *     get_list(0, 1, "news", "" ,"");
 *     $page_list_0 = $page_list;
 *     unset ($page_list);
 * 
 *     get_list(1, 1, "reports", "" ,"");
 *     $page_list_1 = $page_list;
 *     unset ($page_list);
 * 
 *   For more information about how the above get_list()
 *   function works see the comments in 'config.php'
 * 
 */

get_list(0, 1, "uipublish_section","" ,"");   
$page_list_0 = $page_list;
unset ($page_list);


/* Configure Event Sections
 * 
 * Example:
 * 
 *   Let's say you want to display two sections: Calendar and 
 *   workshops. The two directories are named 'calendar' and 
 *   'workshops'. On this page the configuration section 
 *   should look like this:
 * 
 *   get_list_cal(0, 1, "calendar");
 *   $page_list_cal_0 = $page_list_cal;
 *   unset ($page_list_cal);
 * 
 *   get_list_cal(1, 1, "workshops");
 *   $page_list_1 = $page_list_cal;
 *   unset ($page_list_cal);
 * 
 */

get_list_cal(0, 1, "uical_section");
$page_list_cal_0 = $page_list_cal;
unset ($page_list_cal);
    
?>
