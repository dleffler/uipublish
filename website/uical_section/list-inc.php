<?
// $Id: list-inc.php,v 1.5 2002/07/18 02:49:58 chavan Exp $

// This file is called by list.php
require ("../inc/config.php");
require ("../inc/globals.php");
require ("../inc/common.php");
require ("../inc/connect_db.php");
require ("../inc/display_err.php");
require ("../inc/format_date.php");
require ("section_id.php");

connect_db();
get_list_cal($section_id, 2, "", "", "Website Event");
get_list_cal_past($section_id, 2, "", "", "Website Past Event");

?>
