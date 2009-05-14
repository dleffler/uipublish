<?
// $Id: format_date.php,v 1.3 2002/03/12 02:58:24 chavan Exp $


/* Description:   Change date formats 
 * 
 * List of functions:
 *   format_datetime()
 *   format_datelong()
 *   format_dateshort()
 *   format_datemonth()
 */


/* FUNCTION: time_convert 
 * Usage: time_convert("HH:mm:ss", 3) or time_convert("HH:mm PM", 1)
 */
function time_convert($time,$type){
if ($time) {
    $time_hour    = substr($time,0,2);
    $time_minute  = substr($time,3,2);
    $time_ampmsec = substr($time,6,2);
    if ($time_ampmsec == "PM") {     //Convert 12 hour time to 24 hour time
      $time_hour += 12;
      $time_ampmsec = 0;
    } elseif ($time_ampmsec == "AM") { 
      $time_ampmsec = 0;
    }
    if($type == 1):      	// 12 Hour Format with uppercase AM-PM and without leading zeroes
    	$time=date("g:i A", mktime($time_hour,$time_minute,$time_ampmsec));
    elseif($type == 2):  	// 12 Hour Format with uppercase AM-PM and leading zeroes
    	$time=date("h:i A", mktime($time_hour,$time_minute,$time_ampmsec)); 
    elseif($type == 3):  	// 24 Hour Format
    	$time=date("H:i", mktime($time_hour,$time_minute,$time_ampmsec)); 
    elseif($type == 4):
    	// Swatch Internet time 000 through 999
    	$time=date("B", mktime($time_hour,$time_minute,$time_ampmsec)); 
    elseif($type == 5):
    	// 9:30:23 PM
    	$time=date("g:i:s A", mktime($time_hour,$time_minute,$time_ampmsec));
    elseif($type == 6):
    	// 9:30 PM with timezone, EX: EST, MDT
    	$time=date("g:i A T", mktime($time_hour,$time_minute,$time_ampmsec));
    elseif($type == 7):
    	// Different to Greenwich(GMT) time in hours
    	$time=date("O", mktime($time_hour,$time_minute,$time_ampmsec)); 
    endif;
    return $time;
  }
};

/* FUNCTION: format_datetime 
 * "YYYY-mm-dd HH:mm:ss" --> "09:57 AM, June 7"
 * Usage: format_datetime("YYYY-mm-dd HH:mm:ss")
 */

function format_datetime ($datetime) {
    if ($datetime == "") {
	$string = "Date unavailable";
    } else {
	$year   = substr($datetime, 0, 4);
	$month  = substr($datetime, 5, 2);
	$day    = substr($datetime, 8, 2);
	$hour   = substr($datetime, 11, 2);
	$minute = substr($datetime, 14, 2);
	$second = substr($datetime, 17, 2);
	$cal    = date("M d", mktime($hour, $minute, $second, $month, $day, $year));
	$time   = date("h:i A", mktime($hour, $minute, $second, $month, $day, $year));
	$string = "$time, $cal";
    }
    return $string;
}


/* FUNCTION: format_datelong 
 * "YYYY-mm-dd" --> "June 07, 2000"
 * Usage: format_datelong("YYYY-mm-dd")
 */

function format_datelong ($datetime) {
    if ($datetime == "") {
	$string = "Date unavailable";
    } else {
	$year   = substr($datetime, 0, 4);
	$month  = substr($datetime, 5, 2);
	$day    = substr($datetime, 8, 2);
	$cal    = date("F d, Y", mktime($hour, $minute, $second, $month, $day, $year));
	$string = "$cal";
    }
    return $string;
}


/* FUNCTION: format_datetimelong 
 * "YYYY-mm-dd" "hh:mm:ss" --> "June 07, 2000"
 * Usage: format_datetimelong("YYYY-mm-dd", "hh:mm:ss")
 */

function format_datetimelong ($date, $time) {
    if ($date == "") {
	$string = "Date unavailable";
    } else {
	$year   = substr($date, 0, 4);
	$month  = substr($date, 5, 2);
	$day    = substr($date, 8, 2);
  $hour   = substr($time, 0, 2);
  $minute = substr($time, 3, 2);
  $second = substr($time, 6, 2);
	$cal    = date("r", mktime($hour, $minute, $second, $month, $day, $year));
	$string = "$cal";
    }
    return $string;
}


/* FUNCTION: format_dateshort 
 * "YYYY-mm-dd" --> "mm/dd"
 * Usage: format_dateshort("YYYY-mm-dd HH:mm:ss")
 */

function format_dateshort ($datetime) {
    if ($datetime == "") {
	$string = "Date unavailable";
    } else {
	$year   = substr($datetime, 0, 4);
	$month  = substr($datetime, 5, 2);
	$day    = substr($datetime, 8, 2);
	$cal    = date("m/d", mktime($hour, $minute, $second, $month, $day, $year));
	$string = "$cal";
    }
    return $string;
}
 


/* FUNCTION: format_datemonth 
 * "YYYY-mm-dd" --> "June 09"
 */

function format_datemonth($datetime) {
    if ($datetime == "") {
	$string = "Date unavailable";
    } else {
	$year   = substr($datetime, 0, 4);
	$month  = substr($datetime, 5, 2);
	$day    = substr($datetime, 8, 2);
	$cal    = date("M d", mktime($hour, $minute, $second, $month, $day, $year));
	$string = "$cal";
    }
    return $string;
}

?>

