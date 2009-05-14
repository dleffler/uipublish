<?
// $Id: apply_cal.php,v 1.8 2003/03/31 07:19:33 chavan Exp $ 

/* Description:   Takes in data from preview_cal.php
 *                Runs SQL UPDATE if data provided
 *                includes an ID (modify record).
 *                If data has no ID then runs a SQL INSERT
 *                to add a new record.
 */
?>

<? $wysiwyg = ""; ?>
<? include ("inc/top.php") ?>
<? include ("inc/time.php") ?>
<? include ("inc/version.php") ?>
	
<h1>Add/Apply Events</h1>
<p>

<? 
/* clean up the content for display */
$id            =  htmlentities(trim($id));  
$title         =  addslashes(htmlentities(trim($title)));
$summary       =  addslashes(htmlentities(trim($summary)));
$content       =  addslashes(filter_html(trim(urldecode($content))));  
$post_year     =  htmlentities(trim($post_year));
$post_month    =  htmlentities(trim($post_month));
$post_day      =  htmlentities(trim($post_day)); 
$start_time    =  htmlentities(trim($start_time)); 
$expire_year   =  htmlentities(trim($expire_year));
$expire_month  =  htmlentities(trim($expire_month));
$expire_day    =  htmlentities(trim($expire_day)); 
$end_time      =  htmlentities(trim($end_time)); 
$status        =  htmlentities(trim($status));
$weight        =  htmlentities(trim($weight));
$link_title    =  addslashes(htmlentities(trim($link_title)));
$link_url      =  addslashes(htmlentities(trim($link_url)));
$filepath      =  addslashes(htmlentities(trim($filepath)));
$topic_id      =  htmlentities(trim($topic_id));
$section_id    =  htmlentities(trim($section_id));
$postcal       =  htmlentities(stripslashes(trim($postcal)));

// If $topic_id is blank set it to NULL
if ($topic_id == "") {
  $topic_id = "NULL";
}

/* Assemble dates */
// Check if dates is valid 
$post_date = format_form2date("$post_year", "$post_month", "$post_day");
//if ($post_date == "") {$post_date = 'NULL';}
//else  { $post_date = "'" . $post_date . "'"; }

$expire_date = format_form2date("$expire_year", "$expire_month", "$expire_day");
//if ($expire_date == "") {$expire_date = 'NULL';}
//else { $expire_date = "'" . $expire_date . "'"; }

$start_time = time_convert($start_time, 3);
if ($start_time == "") {$start_time = 'NULL';}
else { $start_time = "'" . $start_time . "'"; }
$end_time = time_convert($end_time, 3);
if ($end_time == "") {$end_time = 'NULL';}
else { $end_time = "'" . $end_time . "'"; }

/* create query */
if ($id == "") {
  // Quotes are deliberately absent from $topic_id in VALUES  below
    $query = "INSERT INTO $tbl_name_cal 
       (ID, modify_date, post_date, start_time, expire_date, end_time,
    		status, weight, title, summary, content, 
    		link_title, link_url, filepath, topic_id, section_id)
        VALUES
       (NULL, NOW(), '$post_date', $start_time, '$expire_date', $end_time,
  		'$status', '$weight', '$title', '$summary', '$content',  
  		'$link_title', '$link_url', '$filepath', $topic_id, '$section_id')
		";
} else {
    $query = "UPDATE $tbl_name_cal SET
	       post_date    = '$post_date',
	       start_time   = $start_time,
         expire_date  = '$expire_date',
	       end_time     = $end_time,
 	       status       = '$status',
	       weight       = '$weight',	       
	       title        = '$title',
	       summary      = '$summary',
	       content      = '$content',
	       link_title   = '$link_title',
	       link_url     = '$link_url',
	       filepath     = '$filepath',
         topic_id     = $topic_id,
	       section_id   = '$section_id'
	      WHERE ID = '$id'
	       ";	       
}
$result = mysql_query($query);

if ($result == 0) {
    echo display_err ("Encountered an error.
			The data that you were trying to add/modify
			has probably not been written to the database.
			Please contact administrator with the 
			following information -- Error:" 
		        . mysql_errno() . ": " . mysql_error() );
} else {
    echo("<p><strong>Successful!</strong> Go back to the 
	    <a href=\"list_cal.php?section_id=" 
	    . $section_id 
	    . "\">Manage Events</a> page.</p>");
}

if ($postcal == "ON") {
  echo "<p>Attempting to post this event to the Webcal calendar named <b>". $calendar . "</b></p>\n";
	$GetTime = new Time();
	$dtend = "";
	if ($start_time == 'NULL') {$start_time = '00:00';}
  $dtstart = $GetTime->ConvertTime(mktime(substr($start_time,1,2), substr($start_time,4,2), "00", $post_month, $post_day, $post_year), $tz, 0);
  if ($expire_year) { //end date
     if ($end_time != 'NULL') { //end time
        $dtend = $GetTime->ConvertTime(mktime(substr($end_time,1,2), substr($end_time,4,2), "00", $expire_month, $expire_day, $expire_year), $tz, 0);
     } else { // end date, but no end time
        $dtend = $GetTime->ConvertTime(mktime(substr($start_time,1,2), substr($start_time,4,2), "00", $post_month, $post_day, $post_year), $tz, 0);     
     }
  } elseif ($end_time != 'NULL') { //end time, but no end date
     $dtend = $GetTime->ConvertTime(mktime(substr($end_time,1,2), substr($end_time,4,2), "00", $post_month, $post_day, $post_year), $tz, 0); 
  } 
  
//  if ($topic_id < 6) { // turn subtopics into main topic area
//    $topic_id = "6";
//  }

  $msg = "\"BEGIN:VCALENDAR\015\012";
  $msg .= "METHOD:PUBLISH\015\012";  
  $msg .= "PRODID:-//UIPublish//EN\015\012";
  $msg .= "VERSION:" . $versioninfo . "\015\012";
  $msg .= "TZ:$tz\015\012";
  $msg .= "BEGIN:VEVENT\015\012";
  $msg .= "DTSTART:$dtstart\015\012";
  if($dtend) { $msg .= "DTEND:$dtend\015\012";}
  if($title) { $msg .= "SUMMARY:$title\015\012";}
  if($summary) { $msg .= "DESCRIPTION:$summary\015\012";}
 	if($link_url) { $msg .= "URL:$link_url\015\012";}
  if ($topic_id) { $msg .= "CATEGORIES:APPOINTMENT;$topic[$topic_id]\015\012";}
  $msg .= "END:VEVENT\015\012";        
	$msg .= "END:VCALENDAR\015\012\"";	  
//print $start_time . " " . $post_month . $post_day . $post_year . " " . $end_time . " " . $expire_month . $expire_day . $expire_year . "\n" . $msg;

  if ($webcalendar)
  {
    $response = put_it($server_script, $msg);  
    echo "<b>Results:</b> $response<br>";
  } else {
    $event = array(
      'username' => $calendar,
      'password' => $calendar_password,
      'command' => "add",
      'datatype' => "appointment",
      'data' => $msg
      );
    
    $response = post_it($server_script, $event);
    $prnt = false;
    echo "<b>Results:</b><br>";
    foreach($response as $key=>$val)  { 
      if (strstr($val, "==_end_response_message")) {  
        $prnt = false;
      }
      if ($prnt) {echo $val . "<br>\n";}
      if (strstr($val, "==_begin_response_message")) {
        $prnt = true;
      }
    }
  }
}

// function to pass event to webcal server script via "POST" command
function post_it($url, $event)
{
//  $saveurl = $url;  // Here we save the original $url because it will be altered in the next line and we wouldn't be able to use it like we need to later
  
  $url  = preg_replace("@^http://@i", "", $url);  // $url getting altered here so we saved it in the previous line
  $host = substr($url, 0, strpos($url, "/"));
  $domain  = strstr($url, "/");
		
  $reqbody = ""; 
  
  foreach($event as $key=>$val)  {  // change "$_POST" to "$dataStream" if you still want to send the data to the function instead, but $_POST is fine since its global already

   if (is_array($val)) {      //don't url encode an array (added by an austute person on this site); you don't need to worry about it
      if (!empty($reqbody)) $reqbody .= "&";
      $reqbody .= $key . "=" . $val;
    }
    else {if (!empty($reqbody)) $reqbody .= "&"; $reqbody .= $key . "=" . urlencode($val);}      // "if (!is_empty.." should be changed to if (!empty...", it is here already!
  }

  // here we change "HTTP/1.1" to "HTTP/1.0" or you may get "chunked" data with funny stuff on the end of your post data when its passed
  // a missing "\r" was added to the line "Host: $host (it only had a "\n" before and caused some problems I believe)
  $reqheader = "POST $domain HTTP/1.0\r\n".
               "Host: $host\r\n" . "User-Agent: MSIE\r\n".
               "Content-Type: application/x-www-form-urlencoded\r\n".
               "Content-Length: ".strlen($reqbody)."\r\n\r\n".
               "$reqbody\r\n";
  
// THIS IS THE LINE you add that enables the browser to redirect itself properly (you will see the right url in the address window now!)
// Here you can see the "$saveurl variable we stored from "$url" at the top of the function   // $saveurl must contain "https://www.yoursite.com/pageyourgoingto.php"
//  header("Location: $saveurl");

  // "ssl://" added for SSL and "80" changed to "443" (thanks to another astute person on this thread)
  $socket = fsockopen($host, 80, $errno, $errstr); 

  if (!$socket) {$result["errno"] = $errno; $result["errstr"] = $errstr; return $result;} 
  fputs($socket, $reqheader); 
  while (!feof($socket)) {$result[] = fgets($socket, 4096);} 
  fclose($socket);
	
  return $result; 
}

function put_it($url, $event) 
{
  $useragent="MSIE";

  $fh = tmpfile();
  fwrite($fh, $event);
  rewind($fh);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_USERPWD, $calendar . ":" . $calendar_password);  
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);  
  curl_setopt($ch, CURLOPT_INFILE, $fh);
  curl_setopt($ch, CURLOPT_INFILESIZE, strlen($event));
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_PUT, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);
  curl_close($ch);
  fclose($fh);
	
  return $result; 
}

?>

<? $datepop = ""; $timepop = ""; ?>
<? include ("inc/bot.php") ?>
