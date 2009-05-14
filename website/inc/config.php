<?
// $Id: config.php,v 1.6 2003/04/15 03:22:58 chavan Exp $

/* Description: Configuration Variables */

 $hostname 	= "localhost";    // Name of host e.g. "localhost"
 $username 	= "webuser";      // Username to connect to database
 $password 	= "password";  // Password to connect to database
 $dbname   	= "UIPublish";    // Name of database

/* Base URL for the website e.g. "http://www.website.com" */
$base_url       = "http://www.website.com";

/* Filesystem path name to the website base directory e.g. "/var/www/htdoc" */ 
$base_path      = "/var/www/htdoc";   

/* Page Title Prefix for the website e.g. "UI" */
$base_websitename = "UI Website";

/* Website Description - longer name for the website */
$base_websiteinfo = "Our Website";

/* Webmaster's email address (for error messages) */
// $web_email     = "webmaster@website.com";
$web_email     = "webmaster@website.com";

/* Display after error message */
$contact_mesg  = "Please contact the <a href=\"mailto:" 
                 . $web_email . "\">Webmaster</a>";
				 
/* optional aid - used for embedding audio player */
/* 1PixelOut Location  e.g. "/apps/audio/" or "" if not used*/
$audio = "/apps/audio/";

/* Define Article Sections
 * 
 * WARNING: Once you set these, do not change the order.
 * You can add new sections, but do not delete or change
 * the sequence in which they appear below.
 * 
 * You can keep UIPublish items in several different
 * sections. This is where you define the sections.
 * 
 * Before setting the article sections here you should 
 * have made a copy of the 'uipublish_section' directory 
 * and changed its name to whatever you want it to be.
 * 
 * Example: 
 *   Let's say you want two sections, one for News and 
 *   the other for reports.  Make two copies of 
 *   'uipublish_section' and place them at the base of 
 *   your website. Change the directory names to 'news' 
 *   and 'reports'. Then modify the section setting so
 *   it looks like this:
 * 
 *     $section = array ("News", "Reports");
 *     $section_dir = array ("/news", "/reports");
 * 
 * After setting these values you also need to do two things:
 * 
 * 1) Set the "section_id" variable in the corresponding 
 * section's "section_id.php" file. For example, for the 
 * "News" section, the file ~/web/news/section_id.php 
 * should be modified and the "section_id" variable should 
 * be set to "0". For "Reports" set it to "1" and so on.
 * 
 * 2) Edit the ~/web/mainlist-inc.php file and modify that 
 * file according to the instructions there.
 */

$section = array ("News", "Reports");

// directory locaton name for each of the article sections above

$section_dir = array ("/news", "/reports");


/* Define Event Sections
 * WARNING: Once you set these, do not change the order.
 * You can add new sections, but do not delete or change
 * the sequence in which they appear below.
 * After setting these values, don't forget to set the 
 * "section_id" variable in the corresponding section's
 * "section_id.php" file. For example, for the "Calendar" 
 * section, the file ~/web/calendar/section_id.php should 
 * be modified and the "section_id" variable should be 
 * set to "0". For "Workshops" set it to "1" and so on.
 */

$section_cal = array ("Events");

// directory locaton name for each of the event sections above

$section_dir_cal = array ("/events");


/* Define Topics/Categories for articles and events
 * WARNING: Once you set these, do not change the order.
 * You can add new topics, but do not delete or change
 * the sequence in which they appear below.
 */

$topic = array ("Category 1", "Category 2", "Category 3");

/* List Items Per Page 
 * Tee number of items listed on each admin page.
 * Default number of items if not passed. 
 */

$listlimit = "20";

?>
