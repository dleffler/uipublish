<?
// $Id: connect_db.php,v 1.4 2003/03/31 07:04:11 chavan Exp $ 


/* Description:   Connect to Database 
 *                Uses variable from globals.php
 * 
 * List of functions:
 *   connect_db()
 */

/* FUNCTION: connect_db
 * Connect to MySQL and select database
 * Uses GLOBAL variables
 * Usage connect_db()
 */

function connect_db () {
    global $hostname;
    global $username;
    global $password;
    global $dbname;
    mysql_connect($hostname, $username, $password) 
      or die("Unable to connect to database.");
    mysql_select_db($dbname) or die("Could not select database.");
}

?>

