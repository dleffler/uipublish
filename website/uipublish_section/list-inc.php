<?
// $Id: list-inc.php,v 1.4 2003/04/15 01:01:54 chavan Exp $

// This file is called by list.php
require ("../inc/config.php");
require ("../inc/globals.php");
require ("../inc/common.php");
require ("../inc/connect_db.php");
require ("../inc/display_err.php");
require ("../inc/format_date.php");
require ("section_id.php");

connect_db();
if (is_numeric($start)) {
  $liststart = $start;
}
get_list($section_id, 2, "", $liststart, 12, 1, "", "Website News");

?>
