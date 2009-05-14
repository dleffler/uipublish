<?
// $Id: item-inc.php,v 1.3 2002/03/12 02:58:27 chavan Exp $

// This file is called by item.php
require ("../inc/config.php");
require ("../inc/globals.php");
require ("../inc/common.php");
require ("../inc/connect_db.php");
require ("../inc/display_err.php");
require ("../inc/format_date.php");
require ("section_id.php");

if (!$id) {
    echo display_err("No ID.");
    exit();
}

connect_db();
get_item_cal($id);
?>
