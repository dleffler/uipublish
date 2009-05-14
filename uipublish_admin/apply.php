<?
// $Id: apply.php,v 1.10 2003/06/19 02:20:48 chavan Exp $ 

/* Description:   Takes in data from preview.php
 *                Runs SQL UPDATE if data provided
 *                includes an ID (modify record).
 *                If data has no ID then runs a SQL INSERT
 *                to add a new record.
 */
?>

<? $wysiwyg = ""; ?>
<? include ("inc/top.php") ?>

<h1>Add/Apply</h1>
<p>

<? 
/* clean up the content for writing to database */
$id            =  htmlentities(trim($id));  
$title         =  addslashes(htmlentities(trim($title)));
$summary       =  addslashes(htmlentities(trim($summary)));
$content       =  addslashes(filter_html(trim(urldecode($content))));  
$post_year     =  htmlentities(trim($post_year));
$post_month    =  htmlentities(trim($post_month));
$post_day      =  htmlentities(trim($post_day)); 
$expire_year   =  htmlentities(trim($expire_year));
$expire_month  =  htmlentities(trim($expire_month));
$expire_day    =  htmlentities(trim($expire_day)); 
$status        =  htmlentities(trim($status));
$weight        =  htmlentities(trim($weight));
$link_title    =  addslashes(htmlentities(trim($link_title)));
$link_url      =  addslashes(htmlentities(trim($link_url)));
$filepath      =  addslashes(htmlentities(trim($filepath)));
$topic_id      =  htmlentities(trim($topic_id));
$section_id    =  htmlentities(trim($section_id));

// If $topic_id is blank set it to NULL
if ($topic_id == "") {
  $topic_id = "NULL";
}

/* Assemble dates */
// Check if dates is valid 
$post_date = format_form2date("$post_year", "$post_month", "$post_day");
$expire_date = format_form2date("$expire_year", "$expire_month", "$expire_day");

/* create query */
if ($id == "") {
  // Quotes are deliberately absent from $topic_id in VALUES  below
    $query = "INSERT INTO $tbl_name 
	       (ID, modify_date, post_date, expire_date, 
		status, weight, title, summary, content, 
		link_title, link_url, filepath, topic_id, section_id
		)
              VALUES
	       (NULL, NOW(), '$post_date', '$expire_date', 
		'$status', '$weight', '$title', '$summary', '$content',  
		'$link_title', '$link_url', '$filepath', $topic_id, '$section_id')
		";
} else {
  // Quotes are deliberately absent from $topic_id below
    $query = "UPDATE $tbl_name SET
	       post_date    = '$post_date',
	       expire_date  = '$expire_date',
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
	   <a href=\"list.php?section_id=" 
	 . $section_id 
	 . "\">Manage</a> page.</p>");
}
?>

<? $datepop = ""; $timepop = ""; ?>
<? include ("inc/bot.php") ?>
