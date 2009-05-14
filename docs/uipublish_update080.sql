# $Id: uipublish_addtopics.sql,v 1.1 2003/03/31 06:46:07 chavan Exp $

#  ---------------------------------------------------------------
#  DESCRIPTION	: Update tables for UIPublish Topics and Times
#
#  This sql file will add a column called topic_id to the 
#  UIPublish and UIPublish_cal tables.  It also addes start_time and
#  end_time columns to UIPublish_cal table.
#  ---------------------------------------------------------------

#  ------------------------------------------------------------------
#  VERSION HISTORY:
# 
#  2008_01_20
#  - Add "start_time and end_time" 
# 
#  Modified: D. Leffler 9 January 2007
#
#  ------------------------------------------------------------------

#  ---- NEWS
 

#  ---- CALENDAR

ALTER TABLE UIPublish_cal ADD `start_time` time default NULL;
ALTER TABLE UIPublish_cal ADD `end_time` time default NULL;

# ---- END ----