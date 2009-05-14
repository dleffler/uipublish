<?
// $Id: globals.php,v 1.9 2002/03/12 02:58:15 chavan Exp $ 

/* Description:   Sets global variables */

/* DEFAULT VARIABLES 
 * The following variables do not need configuring.
 * Do not change the following variables unless 
 * you know what you are doing.
 */

/* Database Tables */
 $tbl_name      = "UIPublish";    // Name of table
 $tbl_name_cal  = "UIPublish_cal";// Name of table for calendar

/* Flag to use WYSIWYG editor if available */
 //$wysiwyg       = "";
 
/* Note: The $page_* series of variables are to be used
 * by the HTML author in the HTML pages and they print
 * out all the data for the requested page. These variables
 * are set to "" here but get filled in with data by the
 * get_* series of functions.
 */

/* $page_list 
 * This variable prints out a list of items 
 * This is set by the get_adminlist() function. 
 */
$page_list = "";

/* $page_list_cal 
 * This variable prints out a list of items 
 * This is set by the get_adminlist() function. 
 */
$page_list_cal = "";

/* $page_title (Title)
 * This variable prints out a string which can used
 * as a page title between <TITLE> HTML tags or as the 
 * heading for the page between tags such as <H1>.
 * This is set by the get_item() function. 
 */
$page_title = "";
  
/* $page_content (Content)
 * If used after the get_list() function, this
 * variable prints out HTML formatted text with
 * a listing of matching items.
 * If used after the get_item() function, this
 * variable may print out HTML or regular text 
 * (depending on the data in the database) 
 * of the main content of the item. It is safest
 * to use this within <P> tags to ensure that the
 * content displays correctly whether it is HTMLized
 * or not.
 */
$page_content = "";

/* $page_postdate (Post Date)
 * This variable prints out the date in 
 * a set format. The date is pure text (not HTML)
 * so can be customized by the HTML author when
 * used with the get_item() function. This variable
 * is also used by the get_list() item. 
 */
$page_postdate = "";

/* $page_link (Link)
 * This variable provides a HTMLized hyperlinked
 * string of the link title and its url (or a 
 * hyperlinked url if no title is available) with 
 * the text "Link:" before it.
 * If there is no link information the variable is
 * set blank. This variable is set by the get_item()
 * function.
 */
$page_link = "";

/* $page_linktitle (Link Title) 
 * This variable is actually used by $page_link 
 * but can be used on its own. It is just a text
 * string with the title of the link. The function
 * get_item() sets this variable.
 */
$page_linktitle = "";

/* $page_linkurl (Link URL)
 * This variable is actually used by $page_link 
 * but can be used on its own. It is just a text
 * string with the url of the link. The function
 * get_item() sets this variable.
 */
$page_linkurl = "";

/* DEFAULT VARIABLES FOR CALENDAR
 * The following variables do not need configuring.
 * Do not change the following variables unless 
 * you know what you are doing.
 */

/* Note: The $page_* series of variables are to be used
 * by the HTML author in the HTML pages and they print
 * out all the data for the requested page. These variables
 * are set to "" here but get filled in with data by the
 * get_* series of functions.
 */

/* $page_title_cal (Title)
 * This variable prints out a string which can used
 * as a page title between <TITLE> HTML tags or as the 
 * heading for the page between tags such as <H1>.
 * This is set by the get_item() function. 
 */
$page_title_cal = "";
  
/* $page_content_cal (Content)
 * If used after the get_list() function, this
 * variable prints out HTML formatted text with
 * a listing of matching items.
 * If used after the get_item() function, this
 * variable may print out HTML or regular text 
 * (depending on the data in the database) 
 * of the main content of the item. It is safest
 * to use this within <P> tags to ensure that the
 * content displays correctly whether it is HTMLized
 * or not.
 */
$page_content_cal = "";

/* $page_postdate (Post Date)
 * This variable prints out the date in 
 * a set format. The date is pure text (not HTML)
 * so can be customized by the HTML author when
 * used with the get_item() function. This variable
 * is also used by the get_list() item. 
 */
$page_postdate_cal = "";

/* $page_link (Link)
 * This variable provides a HTMLized hyperlinked
 * string of the link title and its url (or a 
 * hyperlinked url if no title is available) with 
 * the text "Link:" before it.
 * If there is no link information the variable is
 * set blank. This variable is set by the get_item()
 * function.
 */
$page_link_cal = "";

/* $page_linktitle (Link Title) 
 * This variable is actually used by $page_link 
 * but can be used on its own. It is just a text
 * string with the title of the link. The function
 * get_item() sets this variable.
 */
$page_linktitle_cal = "";

/* $page_linkurl (Link URL)
 * This variable is actually used by $page_link 
 * but can be used on its own. It is just a text
 * string with the url of the link. The function
 * get_item() sets this variable.
 */
$page_linkurl_cal = "";


 // DATE VARIABLES
 
/* $now_datetime (Current time) 
 * This variable is used by all pages to determine
 * the current time.
 */
$now_datetime = date("Y-m-d H:i:s");

/* $now_date (Current date) 
 * This variable is used by all pages to determine
 * the current date.
 */
$now_date = date("Y-m-d");
