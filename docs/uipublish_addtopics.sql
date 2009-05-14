# $Id: uipublish_addtopics.sql,v 1.1 2003/03/31 06:46:07 chavan Exp $


#  ---------------------------------------------------------------
#  DESCRIPTION	: Add tables for UIPublish Topics
#
#  This sql file will add a column called topic_id to the 
#  UIPublish and UIPublish_cal tables. 
#  ---------------------------------------------------------------

#  ------------------------------------------------------------------
#  VERSION HISTORY:
# 
#  Modified: A. Chavan 2002-12-15 01:29 Pacific Standard Time
#
#  ------------------------------------------------------------------


#  ---- NEWS
 
ALTER TABLE UIPublish ADD topic_id TINYINT;

#  ---- CALENDAR

ALTER TABLE UIPublish_cal ADD topic_id TINYINT;


# ---- END ----


