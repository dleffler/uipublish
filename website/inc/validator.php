<?php
	/*
	
	Author: 
		Urban Insight
	
	Created:	
		20061205
		
	Description:
		This file contains all functions to validate user input from forms and querystirings 
		which prevent against XSS, SQL injection, invalid input.
		File contains the following functions
		
		Validator() 
		isEmpty() 
		isEmail() 
		cleanStringStrict() 
		cleanStringStrict_nospace() 
		replaceFCK() 
		replace() 
		validate() 
		validate_nospace() 
		validatelessstrict() 
		validateFCK() 
		
				
	Dependencies:
		N/A
		
	*/

class Validator {
	function Validator() {
	}
	
	/*
	
	Function: 
		isEmpty()
	
	Summary: 
		Determins if input string is null or blank
		
	Parameters:
		$value = String input to be tested
		
	Return:
		Returned boolean value
		
	*/
	
	function isEmpty($value) {
		if ($value == null || $value == "") {
			return true;
		}
		else {
			return false;
		}
	}
	
	/*
	
	Function: 
		isEmail()
	
	Summary: 
		Determines if input string is an email address
	
	Parameters:
		$value = String input to be tested
		
	Return:
		Returned boolean value of email
		
	*/
	
	function isEmail($value) {
		return (strlen($eml) == 0 ? true : eregi("^[a-z_0-9\.\-]+@[a-z_0-9\.\-]+$", $eml));
	}
	
	/*
	
	Function: 
		cleanStringStrict()
	
	Summary: 
		Remove any values not equal to A-Z, a-z, 0-9, _ , or space
	
	Parameters:
		$str = String input to be tested
		
	Return:
		Returned update string
		
	*/
	
	function cleanStringStrict($str) {
		return ereg_replace("[^_ a-zA-Z0-9]", "", $str);
	}
	
	
	/*
	
	Function: 
		cleanStringStrict_nospace()
	
	Summary: 
		Remove any values not equal to A-Z, a-z, 0-9, _
	
	Parameters:
		$str = String input to be tested
		
	Return:
		Returned update string
		
	*/
	
	function cleanStringStrict_nospace($str) {
		return ereg_replace("[^_a-zA-Z0-9]", "", $str);
	}
	
	/*
	
	Function: 
		replaceFCK()
	
	Summary: 
		Replace input string with valid database entires for ', ‘, ’, ”, “
	
	Parameters:
		$str = String input to be tested
		
	Return:
		Returned update string
		
	*/
	
	function replaceFCK($str) {
		$tempStr = str_replace("'", "&#39;", $str);
		$tempStr = str_replace("‘", "&#39;", $tempStr);
		$tempStr = str_replace("’", "&#39;", $tempStr);
		$tempStr = str_replace("”", "\"", $tempStr);
		$tempStr = str_replace("“", "\"", $tempStr);
		return $tempStr;
	}
	
	/*
	
	Function: 
		replace()
	
	Summary: 
		Replace input string with valid database entires for ', ‘, ’, ”, “
	
	Parameters:
		$str = String input to be tested
		
	Return:
		Returned update string
		
	*/
	
	function replace($str) {
		$tempStr = str_replace("'", "&#39;", $str);
		$tempStr = str_replace("‘", "&#39;", $tempStr);
		$tempStr = str_replace("’", "&#39;", $tempStr);
		$tempStr = str_replace("”", "\"", $tempStr);
		$tempStr = str_replace("“", "\"", $tempStr);
		$tempStr = str_replace("<", "", $tempStr);
		$tempStr = str_replace(">", "", $tempStr);
		return $tempStr;
	}
	
	/*
	
	Function: 
		validate()
	
	Summary: 
		Clean input strings by calling cleanStringStrict() function and replace() function to strip out
		unwanted characters and convert characters to database valid input.
	
	Parameters:
		$str = String input to be tested
		
	Return:
		Returned update string
		
	*/
	
	function validate($str) {
		$tempStr = $this->cleanStringStrict($str);
		$tempStr = $this->replace($tempStr);
		return $tempStr;
	}
	
	/*
	
	Function: 
		validate_nospace()
	
	Summary: 
		Clean input strings by calling cleanStringStrict_nospace() function and replace() function to strip out
		unwanted characters and convert characters to database valid input.
	
	Parameters:
		$str = String input to be tested
		
	Return:
		Returned update string
		
	*/
	
	function validate_nospace($str) {
		$tempStr = $this->cleanStringStrict_nospace($str);
		$tempStr = $this->replace($tempStr);
		return $tempStr;
	}
	
	/*
	
	Function: 
		validatelessstrict()
	
	Summary: 
		Clean input strings by calling replace() function to strip out
		unwanted characters and convert characters to database valid input.
	
	Parameters:
		$str = String input to be tested
		
	Return:
		Returned update string
		
	*/
	
	function validatelessstrict($str) {
		$tempStr = $this->replace($str);
		return $tempStr;
	}
	
	/*
	
	Function: 
		validateFCK()
	
	Summary: 
		Clean input strings by calling validateFCK() function to strip out
		unwanted characters and convert characters to database valid input.
	
	Parameters:
		$str = String input to be tested
		
	Return:
		Returned update string
		
	*/
	
	function validateFCK($str) {
		return $this->replaceFCK($str);
	}

	/*
	
	Function: 
		validateUnix()
	
	Summary: 
		Clean valid input database datetime by by converting to a unix
    compatable date format.
	
	Parameters:
		$date = Date string input to be converted
		
	Return:
		Returned unix date string
		
	*/	
	function validateUnix($date) {
    if ($date == "") {
    	$string = mktime();
    } else {
    	$year   = substr($date, 0, 4);
    	$month  = substr($date, 5, 2);
    	$day    = substr($date, 8, 2);
      $hour   = substr($date, 11, 2);
      $minute = substr($date, 14, 2);
      $second = substr($date, 17, 2);
    	$cal    = mktime($hour, $minute, $second, $month, $day, $year);
    	$string = "$cal";
    }
    return $string;
  }
	
	}
?>