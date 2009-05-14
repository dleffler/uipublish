<?
// $Id: format_date.php,v 1.4 2002/03/12 02:58:15 chavan Exp $


/* Description:   Change date formats 
 *
 * List of functions:
 *   time_convert() 
 *   format_datetime()
 *   format_datelong()
 *   format_dateshort()
 *   format_datemonth()
 *   format_date2form()
 *   format_form2date() 
 */

/* FUNCTION: time_convert 
 * Usage: time_convert("HH:mm:ss", 3) or time_convert("HH:mm PM", 1)
 */
function time_convert($time, $type){
if ($time) {
    $time_hour=substr($time,0,2);
    $time_minute=substr($time,3,2);
    $time_ampmsec=substr($time,6,2);
    if ($time_ampmsec == "PM") {     //Convert 12 hour time to 24 hour time
      if ($time_hour != 12) {
        $time_hour += 12;
      }
      $time_ampmsec = 0;
    } elseif ($time_ampmsec == "AM") { 
      if ($time_hour == 12) {  
        $time_hour = 0;      
      }  
      $time_ampmsec = 0;
    }
    if ($type == 1):      	// 12 Hour Format with uppercase AM-PM and without leading zeroes
    	$time=date("g:i A", mktime($time_hour, $time_minute, $time_ampmsec));
    elseif ($type == 2):  	// 12 Hour Format with uppercase AM-PM and leading zeroes
    	$time=date("h:i A", mktime($time_hour, $time_minute, $time_ampmsec)); 
    elseif ($type == 3):  	// 24 Hour Format
    	$time=date("H:i", mktime($time_hour, $time_minute, $time_ampmsec)); 
    elseif ($type == 4):
    	// Swatch Internet time 000 through 999
    	$time=date("B", mktime($time_hour, $time_minute, $time_ampmsec)); 
    elseif ($type == 5):
    	// 9:30:23 PM
    	$time=date("g:i:s A", mktime($time_hour, $time_minute, $time_ampmsec));
    elseif ($type == 6):
    	// 9:30 PM with timezone, EX: EST, MDT
    	$time=date("g:i A T", mktime($time_hour, $time_minute, $time_ampmsec));
    elseif( $type == 7):
    	// Different to Greenwich(GMT) time in hours
    	$time=date("O", mktime($time_hour, $time_minute, $time_ampmsec)); 
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

/* FUNCTION: format_datetimeyear
 * "YYYY-mm-dd HH:mm:ss" --> "09:57 AM, June 7, 2000"
 * Usage: format_datetimeyear("YYYY-mm-dd HH:mm:ss")
 */

function format_datetimeyear ($datetime) {
    if ($datetime == "") {
	$string = "Date unavailable";
    } else {
	$year   = substr($datetime, 0, 4);
	$month  = substr($datetime, 5, 2);
	$day    = substr($datetime, 8, 2);
	$hour   = substr($datetime, 11, 2);
	$minute = substr($datetime, 14, 2);
	$second = substr($datetime, 17, 2);
	$cal    = date("M d, Y", mktime($hour, $minute, $second, $month, $day, $year));
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
	$cal    = date("M d, Y", mktime($hour, $minute, $second, $month, $day, $year));
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

/* FUNCTION: format_date2form
 * Convert a supplied date to an HTML form
 * (Returns HTML, use within HTML <FORM> tags
 * 
 * If a date is provided that date is the
 * default selected option in the pulldown menu.
 * If no date is provided the pulldown menus do
 * not have a default selection and instead a 
 * blank value is added to the pulldown menu.
 * 
 * $variable_prefix 
 * 
 * 
 */

  function format_date2form ($datetime, $variable_prefix) {
  global $popcalendarxp;
  
$months = array ("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

    if ($datetime == "") {

	// Month
	$string .= "<select name=\"" . $variable_prefix . "_month\" id=\"" . $variable_prefix . "_month\" onchange=\"if(self.gfPop)gfPop.updateHidden(this)\">";
	$string .= "<option value=\"\" selected></option>";
	$i = 1;	
	while ($i <= 12) {
	    $string .= "<option value=\"" . $i . "\">" . $months[$i-1] . "</option>";
	++$i;
	}
	$string .= "</select>";
	
  // Day
	$string .= "/<select name=\"" . $variable_prefix . "_day\" onchange=\"if(self.gfPop)gfPop.updateHidden(this)\">";
	$i = 1;
	$string .= "<option value=\"\" selected></option>";
	while ($i <= 31) {
	    $string .= "<option value=\"" . $i . "\">" . $i . "</option>";
	    ++$i;
	}
	$string .= "</select>";
	
	//Year
	$string .= "/<select name=\"" . $variable_prefix . "_year\" onchange=\"if(self.gfPop)gfPop.updateHidden(this)\">";
	$string .= "<option value=\"\" selected></option>";
	$i = 2000;
	while ($i <= 2010) {
	    $string .= "<option value=\"" . $i . "\">" . $i . "</option>";
	    ++$i;
	}
	$string .= "</select>";
    } else {
	$year  = substr($datetime, 0, 4);
	$month = substr($datetime, 5, 2);
	$day   = substr($datetime, 8, 2);
	$year  = (int) $year;
	$month = (int) $month;
	$day   = (int) $day;
	
	// Create Month Form
	$string = "<select name=\"" . $variable_prefix . "_month\" id=\"" . $variable_prefix . "_month\" onchange=\"if(self.gfPop)gfPop.updateHidden(this)\">";
	$string .= "<option value=\"\"></option>";
	$i = 1;
	while ($i <= 12) {
	    if ($i == $month) {
		$string .= "<option value=\"" . sprintf("%02d", $i) . "\"selected>" . $months[$i-1] . "</option>";
	    } else {
		$string .= "<option value=\"" . sprintf("%02d", $i) . "\">" . $months[$i-1] . "</option>";
	    }
	    ++$i;
	}
	$string .= "</select>"; 

	//Create Day Form
	$string .= "/<select name=\"" . $variable_prefix . "_day\" onchange=\"if(self.gfPop)gfPop.updateHidden(this)\">";
	$string .= "<option value=\"\"></option>";
	$i = 1;
	while ($i <= 31) {
	    if ($i == $day) {
		$string .= "<option value=\"" . sprintf("%02d", $i) . "\"selected>" . $i . "</option>";
	    } else {
		$string .= "<option value=\"" . sprintf("%02d", $i) . "\">" . $i . "</option>";
	    }
	    ++$i;
	}
	$string .= "</select>"; 
	
	// Create Year Form
	$string .= "/<select name=\"" . $variable_prefix . "_year\" onchange=\"if(self.gfPop)gfPop.updateHidden(this)\">";
	$string .= "<option value=\"\"></option>";
	$i = 2000;
	while ($i <= 2010) {
	    if ($i == $year) {
		$string .= "<option value=\"" . $i . "\"selected>" . $i . "</option>";
	    } else {
		$string .= "<option value=\"" . $i . "\">" . $i . "</option>";
	    }
	    ++$i;
	}
	$string .= "</select>";
    }

	if ($popcalendarxp) {
  	$string .= "<INPUT name=\"popcal\" onclick=\"var fm=this.form;if(self.gfPop)gfPop.";
  	if ($variable_prefix == "post") {
        $string .= "fStartPop(fm.post,fm.expire);\" type=\"button\" value=\"...\">";
    } else if ($variable_prefix == "expire") {
        $string .= "fEndPop(fm.post,fm.expire);\" type=\"button\" value=\"...\">";
    } else {
        $string .= "fPopCalendar(fm." . $variable_prefix . ",null,null,fm." . $variable_prefix . "_year);\" type=\"button\" value=\"...\">";
    }
  }    
  
 	$string .= "<input name=\"" . $variable_prefix . "\" type=\"hidden\" value=\"" . $day . "/" . $month . "/" . $year . "\">";

//    $string .= "[M/D/Y]";  
    return $string;
}

/* FUNCTION: format_form2date
 * Convert a date supplied via a form into yyyy-mm-yy
 * To be used to read data submitted using format_date2form
 * Also validates the date to make sure it is a valid date.
 * If date is not valid it returns an empty string.
 */

function format_form2date ($year, $month, $day) {
  if ($year == "") {
   $string = "";
    } else if ((checkdate("$month", "$day", "$year")) <> "") {
	$string = $year . "-" . $month . "-" . $day;
    } else {
	$string = "";
    }
    return $string;
}
?>
