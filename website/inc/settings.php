<?php
	/*
	
	Author: 
		Urban Insight
	
	Created:	
		20061205
		
	Description:
		This file contains all the settings to be customized by the user for the UIPublish2 installation.
		This file also contains the following functions for these settings to be used by UIPublish2.
		
		Settings()
		getHost()
		getSQLLogin()
		getSQLPasswd()
		getDatabase()
		getItemsPerPage()
		getAddress()
		getRootRelative()
		getRootRelativeAdmin()
		getRootForHtaccess()
		getServerRoot()
		getDateFormat()
		safeForRTE()
		snExists()
		getNextOrderNum()
		writeToFile()
		deleteFromFile()
		
	Dependencies:
		N/A
		
	*/

class Settings
{
	//  Variables to be customized by user
	
	// Host of MySQL location
	var $mysql_host = "harrisonhills.org";
	
	// MySQL username for login
	var $mysql_name = "webuser";	
	
	// MySQL password for login						
	var $mysql_passwd = "sb3467";
	
	// MySQL Database to be used
	var $database = "harrisonhills_org_uipublish2";		
	
	// Number of items to appear per page in the UIPublish admin						
	var $itemsPerPage = 15;											
	
	/********************************
	Domain of installed UIPublish2 instance 
	No trailing "/" 
	********************************/
	var $address = "http://www.harrisonhills.org/uip";							
	
	/********************************
	Relative path to root of website, where .htaccess is
	Start with "/", end with "/" 
	*********************************/
	var $rootRelative = "/uip/";			
  
  /********************************
	Relative path to directory where UIPublish2 is installed
	Start with "/", end with "/" 
	*********************************/
	var $rootRelativeAdmin = "/admin/uipublish2/";
	
	/********************************
	Relative path to website root from UIPublish2 admin "control" folder
	Do not start with "/", end with "/"
	*********************************/
	var $serverRoot = "../../uip/";	
	
	/********************************
	Date Format used for display
	"F j, Y, g:i a"                = March 10, 2001, 5:16 pm
	"m.d.y"                        = 03.10.01
	"j, n, Y"                      = 10, 3, 2001
	"Ymd"                          = 20010310
    "h-i-s, j-m-y, it is w Day z   = 05-16-17, 10-03-01, 1631 1618 6 Fripm01
	"\i\t \i\s \t\h\e jS \d\a\y."  = It is the 10th day.
	"D M j G:i:s T Y"              = Sat Mar 10 15:16:08 MST 2001
	"H:m:s \m \i\s\ \m\o\n\t\h"    = 17:03:17 m is month
	"H:i:s"                        = 17:16:17
	*********************************/
	var $dateFormat = "F j, Y";
  
	/*
	
	Function: 
		Settings()
	
	Summary: 
		Strip quotes if Magic Quotes is turned on
		
	Parameters:
		N/A
		
	Return:
		Returned input updated results without quotes
		
	*/  
    
	function Settings()	{
	// If Magic Quotes is turned on
		if (get_magic_quotes_gpc()){
			$_GET    = array_map('stripslashes', $_GET);
			$_POST  = array_map('stripslashes', $_POST);
			$_COOKIE = array_map('stripslashes', $_COOKIE);
		}
	}
  
	/*
	
	Function: 
		getHost()
	
	Summary: 
		Return the MySQL host defined in the variables above
		
	Parameters:
		N/A
		
	Return:
		Returned MySQL host
		
	*/  
	function getHost(){
		return $this->mysql_host;
	}
  
  	/*
	
	Function: 
		getSQLLogin()
	
	Summary: 
		Return the MySQL login username defined in the variables above
		
	Parameters:
		N/A
		
	Return:
		Returned MySQL login username
		
	*/  
	function getSQLLogin(){
		return $this->mysql_name;
	}
	
  	/*
	
	Function: 
		getSQLPasswd()
	
	Summary: 
		Return the MySQL login password defined in the variables above
		
	Parameters:
		N/A
		
	Return:
		Returned MySQL login password
		
	*/  
	function getSQLPasswd(){
		return $this->mysql_passwd;
	}
	
  	/*
	
	Function: 
		getDatabase()
	
	Summary: 
		Return the MySQL datbase in the variables above
		
	Parameters:
		N/A
		
	Return:
		Returned MySQL database
		
	*/  
	function getDatabase(){
		return $this->database;
	}
	
  	/*
	
	Function: 
		getItemsPerPage()
	
	Summary: 
		Return the number of items on the admin page in the variables above
		
	Parameters:
		N/A
		
	Return:
		Returned number of items per page in the UIPublish2 admin page
		
	*/  
	function getItemsPerPage(){
		return $this->itemsPerPage;
	}
	
  	/*
	
	Function: 
		getAddress()
	
	Summary: 
		Return the domain of the UIPublish2 in the variables above
		
	Parameters:
		N/A
		
	Return:
		Returned domain
		
	*/  
	function getAddress(){
		return $this->address;
	}
	
  	/*
	
	Function: 
		getRootRelative()
	
	Summary: 
		Return the relative path to the website root in the variables above
		
	Parameters:
		N/A
		
	Return:
		Returned relative path to the website root
		
	*/  
	function getRootRelative(){
		return $this->rootRelative;
	}
	
  	/*
	
	Function: 
		getRootRelativeAdmin()
	
	Summary: 
		Return the relative path from the UIPublish2 admin "control" folder in the variables above
		
	Parameters:
		N/A
		
	Return:
		Returned relative path to the website root from UIPublish admin
		
	*/  
	function getRootRelativeAdmin(){
		return $this->rootRelativeAdmin;
	}
	
  	/*
	
	Function: 
		getRootForHtaccess()
	
	Summary: 
		Return the relative path for the .htaccess files in the variables above
		
	Parameters:
		N/A
		
	Return:
		Returned relative path to the .htaccess files
		
	*/  
	function getRootForHtaccess(){
		return $this->rootForHtaccess;
	}
	
 	/*
	
	Function: 
		getServerRoot()
	
	Summary: 
		Return the relative path for the server root
		
	Parameters:
		N/A
		
	Return:
		Returned relative path to the webserver root
				
	*/  
	function getServerRoot(){
		return $this->serverRoot;
	}
	
  	/*
	
	Function: 
		getDateFormat()
	
	Summary: 
		Return the formatted date according to variable above
		
	Parameters:
		N/A
		
	Return:
		Returned formatted date
		
	*/  
	function getDateFormat(){
		return $this->dateFormat;
	}
	
  	/*
	
	Function: 
		safeForRTE()
	
	Summary: 
		Parses values to be safe for input into FCKEditor
		
	Parameters:
		$value  = $value of content to be put into FCKEditor
		
	Return:
		Returned FCKEditor safe values
				
	*/  
	function safeForRTE($value){
		// Get rid of line breaks
		//$value = ereg_replace("//", "", $value);
		$value = ereg_replace("<script", "", $value);
		$value = ereg_replace("</script>", "", $value);
		$value = str_replace("\n", "", $value);
		$value = str_replace("\r", "", $value);
		$value = str_replace("'", "&#39;", $value);
		return $value;
	}
  
  	/*
	
	Function: 
		snExists()
	
	Summary: 
		Check to see if directory name already exists in the database
		
	Parameters:
		$sn = section directory name
		
	Return:
		Returned boolean value of whether or not directory exists
				
	*/ 
	function snExists($sn){
		$database = new Database();
		$category_list = $database->runSQL("SELECT sn FROM uip_category");
		for ($i = 0; $i < mysql_numrows($category_list); $i++) {
			if (mysql_result($category_list, $i, "sn") == $sn)
			return true;
		}
		
		$section_list = $database->runSQL("SELECT sn FROM uip_section");
		for ($i = 0; $i < mysql_numrows($section_list); $i++) {
			if (mysql_result($section_list, $i, "sn") == $sn) {
				return true;
			}
		}
		return false;
	}
  
  	/*
	
	Function: 
		getNextOrderNum()
	
	Summary: 
		Check next ordering number for a specified section
		
	Parameters:
		$section_id = section ID number
		
	Return:
		Returned value of next number in specified section
				
	*/ 
	function getNextOrderNum($section_id){
		$database = new Database();
		$item_info = $database->runSQL("SELECT MAX(ordering) FROM uip_item WHERE section_id = '$section_id'");
		if (mysql_numrows($item_info) == 0) {
			return 1;
		}
		else {
			return mysql_result($item_info, 0, "MAX(ordering)") + 1;
		}
	}
  
  	/*
	
	Function: 
		writeToFile()
	
	Summary: 
		Writes specified string into file.  File must have write permission.
		
	Parameters:
		$fname = filename
		$strText = string to put into file
		
	Return:
		N/A
				
	*/   
	function writeToFile($fname, $strText) { 
		$lines = file($fname);
		$out = "";
		foreach ($lines as $line) {
			$out .= $line;
		}
		$out .= $strText . "\r\n";
		$f = fopen($fname, "w"); 
		fwrite($f, $out); 
		fclose($f);
	}
  
  	/*
	
	Function: 
		deleteFromFile()
	
	Summary: 
		Delete specified matching string in file.  File must have write permission.
		
	Parameters:
		$fname = filename
		$exclude = string to be deleted from file
		
	Return:
		N/A
				
	*/   
  function deleteFromFile($fname, $exclude) 
  { 
    $lines = file($fname);
    $out = "";
    foreach ($lines as $line) {
      if (strstr($line, $exclude) == "") {
        $out .= $line;
      }
    }
    $f = fopen($fname, "w"); 
    fwrite($f, $out); 
    fclose($f);
  }
}
?>